<?php

namespace App\Http\Controllers;

use App\Models\PengumpulanModel;
use Illuminate\Http\Request;
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
        return view('kompen_progres.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'activeSubMenu' => $activeSubMenu
        ]);
    }

    // List of tasks with necessary fields (tugas_nama, mahasiswa_nama, foto_sebelum, foto_sesudah, tanggal)
    public function list(Request $request)
    {
        $progres = PengumpulanModel::with(['tugas', 'mahasiswa'])
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

            // Validasi
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
                // Menangani foto_sebelum jika ada file baru
                if ($request->hasFile('foto_sebelum')) {
                    // Hapus file lama jika ada
                    if ($task->foto_sebelum && Storage::disk('public')->exists('foto_sebelum/' . $task->foto_sebelum)) {
                        Storage::disk('public')->delete('foto_sebelum/' . $task->foto_sebelum);
                    }

                    // Simpan file baru
                    $fotoSebelum = $request->file('foto_sebelum');
                    $fotoSebelumPath = $fotoSebelum->store('public/foto_sebelum');
                    $task->foto_sebelum = basename($fotoSebelumPath); // Simpan nama file
                }

                // Menangani foto_sesudah jika ada file baru
                if ($request->hasFile('foto_sesudah')) {
                    // Hapus file lama jika ada
                    if ($task->foto_sesudah && Storage::disk('public')->exists('foto_sesudah/' . $task->foto_sesudah)) {
                        Storage::disk('public')->delete('foto_sesudah/' . $task->foto_sesudah);
                    }

                    // Simpan file baru
                    $fotoSesudah = $request->file('foto_sesudah');
                    $fotoSesudahPath = $fotoSesudah->store('public/foto_sesudah');
                    $task->foto_sesudah = basename($fotoSesudahPath); // Simpan nama file
                }

                // Update tanggal secara otomatis
                $task->tanggal = now(); // Mengupdate kolom tanggal dengan waktu saat ini

                // Simpan perubahan ke database
                $task->save();

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
