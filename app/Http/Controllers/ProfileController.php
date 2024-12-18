<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\DosenModel;
use App\Models\MahasiswaModel;
use App\Models\TendikModel;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function showProfile()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors('Anda harus login terlebih dahulu.');
        }

        $breadcrumb = (object) [
            'title' => 'Profile',
            'list' => [
                'Home',
                // (object) ['url' => route('profile.profil'), 'label' => 'Profile'],
                'Profile'
            ]
        ];

        if ($user->level_id == 5) {
            $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();
            $user['mahasiswa'] = $mahasiswa;
            $user['avatar'] = $mahasiswa->foto;
        } else if ($user->level_id == 3) {
            $tendik = TendikModel::where('user_id', $user->user_id)->first();
            $user['tendik'] = $tendik;
            $user['avatar'] = $tendik->foto;
        } else if ($user->level_id == 2) {
            $dosen = DosenModel::where('user_id', $user->user_id)->first();
            $user['dosen'] = $dosen;
            $user['avatar'] = $dosen->foto;
        } else {
            $admin = AdminModel::where('user_id', $user->user_id)->first();
            $user['admin'] = $admin;
            $user['avatar'] = $admin->foto;
        }

        $activeMenu = 'profile';
        $activeSubMenu = '';
        return view('profile.profil', compact('user', 'breadcrumb', 'activeMenu', 'activeSubMenu'));
    }

    // Menampilkan halaman edit profil
    public function edit()
    {
        $user = Auth::user();

        $breadcrumb = (object) [
            'title' => 'Edit Profile',
            'list' => [
                'Home',
                // (object) ['label' => 'Profile', 'url' => route('profile.edit')],
                'Edit'
            ]
        ];

        if ($user->level_id == 5) {
            $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();
            $user['no_telp'] = $mahasiswa->no_telp;
            $user['avatar'] = $mahasiswa->foto;
            $user['username'] = $mahasiswa->username;
        } else if ($user->level_id == 3) {
            $tendik = TendikModel::where('user_id', $user->user_id)->first();
            $user['username'] = $tendik->username;
            $user['avatar'] = $tendik->foto;
        } else if ($user->level_id == 2) {
            $dosen = DosenModel::where('user_id', $user->user_id)->first();
            $user['username'] = $dosen->username;
            $user['avatar'] = $dosen->foto;
        } else {
            $admin = AdminModel::where('user_id', $user->user_id)->first();
            $user['username'] = $admin->username;
            $user['avatar'] = $admin->foto;
        }

        $activeMenu = 'profile';
        $activeSubMenu = '';
        return view('profile.edit', compact('user', 'breadcrumb', 'activeMenu', 'activeSubMenu'));
    }

    // Memperbarui data profil
    public function update(Request $request)
    {
        $user = Auth::user();

        // Update nama dan username
        if ($user->level_id === 5) $user = MahasiswaModel::where('user_id', $user->user_id)->first();
        else if ($user->level_id === 3) $user = TendikModel::where('user_id', $user->user_id)->first();
        else if ($user->level_id === 2) $user = DosenModel::where('user_id', $user->user_id)->first();
        else  $user = AdminModel::where('user_id', $user->user_id)->first();
        $username = $request->username ?? null;
        $no_telp = $request->no_telp ?? null;
        $password = $request->password ?? null;
        $username && $user->username = $username;
        $no_telp && $user->no_telp = $no_telp;
        $password && $user->password = bcrypt($password);

        // Handle upload avatar
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('images/profile', 'public');
            $user->foto = $avatarPath;
        }

        $user->save();

        return redirect()->route('profile.profil')->with('success', 'Profil berhasil diperbarui!');
    }

    // Menampilkan halaman ganti password
    public function changePassword()
    {
        $breadcrumb = (object) [
            'title' => 'Ganti Password',
            'list' => [
                (object) ['url' => route('profile.profil'), 'label' => 'Profile'],
                'Ganti Password'
            ]
        ];

        return view('profile.password', compact('breadcrumb'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Log untuk debug
        \Log::info('User ID: ' . $user->id);
        \Log::info('Current Password: ' . $request->current_password);

        // Cek apakah password lama benar
        if (!Hash::check($request->current_password, $user->password)) {
            \Log::info('Old password does not match');
            return back()->withErrors(['current_password' => 'Password lama salah']);
        }

        // Update password baru
        $user->password = Hash::make($request->new_password);
        $user->save();

        \Log::info('Password updated successfully for User ID: ' . $user->id);
        return redirect()->route('profile.profil')->with('success', 'Password berhasil diubah.');
    }
}