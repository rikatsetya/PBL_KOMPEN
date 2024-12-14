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
}