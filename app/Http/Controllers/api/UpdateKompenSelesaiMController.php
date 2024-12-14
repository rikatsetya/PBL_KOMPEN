<?php

namespace App\Http\Controllers\Api;

use App\Models\PengumpulanModel;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UpdateKompenSelesaiMController extends Controller
{
    // Menampilkan semua data tugas beserta informasi mahasiswa sesuai dengan user login
    public function showAllData(Request $request)
    {
        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Mencari mahasiswa berdasarkan username dari user yang login
        $mahasiswa = MahasiswaModel::where('username', $user->username)->first();

        // Jika mahasiswa tidak ditemukan, kembalikan error
        if (!$mahasiswa) {
            return response()->json(['error' => 'Mahasiswa tidak ditemukan'], 404);
        }

        // Ambil semua data pengumpulan tugas milik mahasiswa yang sedang login
        $data = PengumpulanModel::with(['tugas', 'mahasiswa'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // Menampilkan detail tugas berdasarkan pengumpulan_id sesuai user login
    public function showTaskDetail(Request $request)
    {
        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Mencari mahasiswa berdasarkan username dari user yang login
        $mahasiswa = MahasiswaModel::where('username', $user->username)->first();

        // Jika mahasiswa tidak ditemukan, kembalikan error
        if (!$mahasiswa) {
            return response()->json(['error' => 'Mahasiswa tidak ditemukan'], 404);
        }

        // Ambil pengumpulan_id dari body request
        $id = $request->input('pengumpulan_id');

        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'Pengumpulan ID tidak ditemukan'
            ], 400);
        }

        // Ambil data pengumpulan berdasarkan pengumpulan_id milik mahasiswa yang login
        $taskDetail = PengumpulanModel::with(['tugas', 'mahasiswa'])
            ->where('pengumpulan_id', $id)
            ->where('mahasiswa_id', $mahasiswa->id) // Memastikan data sesuai dengan mahasiswa yang login
            ->first();

        if (!$taskDetail) {
            return response()->json([
                'success' => false,
                'message' => 'Task tidak ditemukan atau tidak milik Anda'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $taskDetail
        ]);
    }
}
