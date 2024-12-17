<?php

namespace App\Http\Controllers;

use App\Models\PengumpulanModel;
use App\Models\UserModel;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class UpdateKompenSelesaiMController extends Controller
{
    // Index page
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Update Kompen Selesai',
            'list' => ['Home', 'Update Kompen Selesai']
        ];
        $page = (object) [
            'title' => 'Update Kompen Selesai Tugas'
        ];
        $activeMenu = 'selesai';
        $activeSubMenu = '';
        $user = UserModel::all();
        return view('kompen_selesai.indexm', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'activeSubMenu' => $activeSubMenu
        ]);
    }
    public function list(Request $request)
    {
        $user = Auth::user(); // Mendapatkan data pengguna yang sedang login

        // Mencari mahasiswa berdasarkan user yang sedang login
        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        // Jika mahasiswa tidak ditemukan, kembalikan error
        if (!$mahasiswa) {
            return response()->json(['error' => 'Mahasiswa tidak ditemukan'], 404);
        }

        // Mengambil data pengumpulan yang sesuai dengan mahasiswa_id yang ditemukan
        $selesai = PengumpulanModel::with(['tugas', 'mahasiswa'])
            ->where('mahasiswa_id', $mahasiswa->mahasiswa_id) // Filter berdasarkan mahasiswa_id
            ->select('pengumpulan_id', 'tugas_id', 'mahasiswa_id', 'foto_sebelum', 'foto_sesudah', 'tanggal', 'status', 'alasan')
            ->get();

        return DataTables::of($selesai)
            ->addIndexColumn()
            ->addColumn('tugas_nama', function ($selesai) {
                return $selesai->tugas->tugas_nama;
            })
            ->addColumn('mahasiswa_nama', function ($selesai) {
                return $selesai->mahasiswa->mahasiswa_nama;
            })
            ->addColumn('status', function ($selesai) {
                return $selesai->status ? $selesai->status : 'Belum Diperbarui';
            })
            ->make(true);
    }
}
