<?php

namespace App\Http\Controllers\Api;

use App\Models\PengumpulanModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateKompenSelesaiAController extends Controller
{
    // Menampilkan semua data tugas beserta informasi mahasiswa
    public function showAllData()
    {
        // Ambil semua data pengumpulan tugas beserta tugas dan mahasiswa
        $data = PengumpulanModel::with(['tugas', 'mahasiswa'])->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // Menampilkan detail tugas berdasarkan pengumpulan_id
    public function showTaskDetail(Request $request)
    {
        // Ambil pengumpulan_id dari body request
        $id = $request->input('pengumpulan_id');

        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'Pengumpulan ID tidak ditemukan'
            ], 400);
        }

        // Ambil data pengumpulan berdasarkan pengumpulan_id
        $taskDetail = PengumpulanModel::with(['tugas', 'mahasiswa'])
            ->where('pengumpulan_id', $id)
            ->first();

        if (!$taskDetail) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $taskDetail
        ]);
    }

    // Mengupdate status dan alasan
    public function updateStatusAndReason(Request $request)
    {
        // Validasi input status dan alasan
        $validated = $request->validate([
            'status' => 'required|in:terima,tolak', // Hanya menerima 'terima' atau 'tolak'
            'alasan' => 'required_if:status,tolak|string|max:255', // Alasan hanya diperlukan jika status adalah 'tolak'
            'pengumpulan_id' => 'required|integer', // ID pengumpulan
        ]);

        // Mencari task berdasarkan ID
        $task = PengumpulanModel::find($validated['pengumpulan_id']);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found'
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
