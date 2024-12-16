<?php

namespace App\Http\Controllers;

use App\Models\PengumpulanModel;
use App\Models\UserModel;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

class UpdateKompenProgresController extends Controller
{
    // Index page
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Update Kompen Progres',
            'list' => ['Home', 'Update Kompen Progres']
        ];
        $page = (object) [
            'title' => 'Update Kompen Progres Tugas'
        ];
        $activeMenu = 'progres';
        $activeSubMenu = '';
        $user = UserModel::all();
        return view('kompen_progres.index', [
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

        // Mengambil data progres hanya untuk mahasiswa yang sedang login
        $progres = PengumpulanModel::with(['tugas', 'mahasiswa'])
            ->where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->select('pengumpulan_id', 'tugas_id', 'mahasiswa_id', 'foto_sebelum', 'foto_sesudah', 'tanggal')
            ->get();

        return DataTables::of($progres)
            ->addIndexColumn()
            ->addColumn('tugas_nama', function ($progres) {
                return $progres->tugas->tugas_nama;
            })
            ->addColumn('mahasiswa_nama', function ($progres) {
                return $progres->mahasiswa->mahasiswa_nama;
            })
            ->addColumn('aksi', function ($progres) {
                return '<button onclick="modalAction(\'' . url('/kompen_progres/' . $progres->pengumpulan_id . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // Show form to update foto_sebelum and foto_sesudah
    public function edit(string $id)
    {
        $progres = PengumpulanModel::find($id);
        return view('kompen_progres.edit', ['progres' => $progres]);
    }

    // Handle the update of foto_sebelum and foto_sesudah
    public function update(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi input untuk file foto
            $rules = [
                'foto_sebelum' => 'nullable|mimes:jpeg,png,jpg|max:4096',
                'foto_sesudah' => 'nullable|mimes:jpeg,png,jpg|max:4096',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed.',
                    'msgField' => $validator->errors()
                ]);
            }

            // Cari task berdasarkan ID
            $task = PengumpulanModel::find($id);

            // Cek apakah task ditemukan
            if ($task) {
                $updateData = []; // Array untuk menyimpan data yang diupdate

                // Proses foto_sebelum
                if ($request->hasFile('foto_sebelum')) {
                    // Hapus file lama jika ada
                    if ($task->foto_sebelum && Storage::disk('public')->exists($task->foto_sebelum)) {
                        Storage::disk('public')->delete($task->foto_sebelum);
                    }

                    // Simpan file baru
                    $file = $request->file('foto_sebelum');
                    $filename = time() . '_sebelum.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs($filename);
                    $updateData['foto_sebelum'] = $path; // Masukkan path ke array data
                    $file->move('foto_sebelum/', $filename);
                }

                // Proses foto_sesudah
                if ($request->hasFile('foto_sesudah')) {
                    // Hapus file lama jika ada
                    if ($task->foto_sesudah && Storage::disk('public')->exists($task->foto_sesudah)) {
                        Storage::disk('public')->delete($task->foto_sesudah);
                    }

                    // Simpan file baru
                    $file = $request->file('foto_sesudah');
                    $filename = time() . '_sesudah.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs($filename);
                    $updateData['foto_sesudah'] = $path; // Masukkan path ke array data
                    $file->move('foto_sesudah/', $filename);
                }

                // Update kolom tanggal secara otomatis
                $updateData['tanggal'] = now();

                // Update data ke database
                $task->update($updateData);

                // Respons sukses
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                // Task tidak ditemukan
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        // Jika bukan request AJAX, redirect ke halaman utama
        return redirect('/');
    }
}
