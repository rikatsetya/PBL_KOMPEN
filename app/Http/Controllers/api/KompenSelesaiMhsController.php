<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaModel;
use App\Models\PengumpulanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KompenSelesaiMhsController extends Controller
{
    public function showAllData(Request $request)
    {
        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Mencari mahasiswa berdasarkan username dari user yang login
        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        // Jika mahasiswa tidak ditemukan, kembalikan error
        if (!$mahasiswa) {
            return response()->json(['error' => 'Mahasiswa tidak ditemukan'], 404);
        }

        // Ambil semua data pengumpulan tugas milik mahasiswa yang sedang login
        $data = PengumpulanModel::with(['tugas', 'mahasiswa'])
            ->where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
