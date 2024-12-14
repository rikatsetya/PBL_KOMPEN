<?php

namespace App\Http\Controllers\Api;

use App\Models\PengumpulanModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UpdateKompenSelesaiAController extends Controller
{
    public function showAllData()
    {
        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Ambil semua data pengumpulan tugas beserta tugas dan mahasiswa berdasarkan user_id
        $data = PengumpulanModel::with(['tugas', 'mahasiswa'])
            ->where('user_id', $user->id) // Filter by user_id
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // Menampilkan detail tugas berdasarkan pengumpulan_id dan user_id
    public function showTaskDetail(Request $request)
    {
        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Ambil pengumpulan_id dari body request
        $id = $request->input('pengumpulan_id');

        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'Pengumpulan ID tidak ditemukan'
            ], 400);
        }

        // Ambil data pengumpulan berdasarkan pengumpulan_id dan user_id
        $taskDetail = PengumpulanModel::with(['tugas', 'mahasiswa'])
            ->where('pengumpulan_id', $id)
            ->where('user_id', $user->id) // Filter by user_id
            ->first();

        if (!$taskDetail) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found or not associated with the current user'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $taskDetail
        ]);
    }

    // Mengupdate status dan alasan berdasarkan user_id
    public function updateStatusAndReason(Request $request)
    {
        // Validasi input status dan alasan
        $validated = $request->validate([
            'status' => 'required|in:terima,tolak', // Hanya menerima 'terima' atau 'tolak'
            'alasan' => 'required_if:status,tolak|string|max:255', // Alasan hanya diperlukan jika status adalah 'tolak'
            'pengumpulan_id' => 'required|integer', // ID pengumpulan
        ]);

        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Mencari task berdasarkan ID dan user_id
        $task = PengumpulanModel::where('pengumpulan_id', $validated['pengumpulan_id'])
            ->where('user_id', $user->id) // Filter by user_id
            ->first();

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found or not associated with the current user'
            ], 404); // Kembalikan status 404 jika task tidak ditemukan
        }

        // Update status
        $task->status = $validated['status'];

        // Jika status "tolak", alasan harus ada
        if ($validated['status'] === 'tolak') {
            $task->alasan = $validated['alasan']; // Simpan alasan jika status 'tolak'
        } else {
            $task->alasan = null; // Jika status 'terima', alasan harus kosong
        }

        // Simpan perubahan ke database
        $task->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully'
        ]);
    }
}
