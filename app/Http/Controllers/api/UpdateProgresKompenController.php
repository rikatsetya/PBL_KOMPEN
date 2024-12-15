<?php

namespace App\Http\Controllers\Api;

use App\Models\PengumpulanModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateProgresKompenController extends Controller
{
    // Menampilkan semua data tugas beserta informasi mahasiswa
    public function allData()
    {
        // Ambil semua data pengumpulan tugas beserta tugas dan mahasiswa
        $data = PengumpulanModel::with(['tugas', 'mahasiswa'])->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // Menampilkan detail tugas berdasarkan pengumpulan_id
    public function showDetail(Request $request)
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
    public function updateData(Request $request)
    {
        try {
            // Validasi input foto
            $validated = $request->validate([
                'pengumpulan_id' => 'required|integer',
                'foto_sebelum' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'foto_sesudah' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $task = PengumpulanModel::findOrFail($validated['pengumpulan_id']);

            // Handle file upload and update task
            if ($request->hasFile('foto_sebelum')) {
                // Handle 'foto_sebelum' upload
                // Check if file exists and store it
            }

            if ($request->hasFile('foto_sesudah')) {
                // Handle 'foto_sesudah' upload
                // Check if file exists and store it
            }

            $task->save();

            return response()->json([
                'success' => true,
                'message' => 'Photos updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating data: ' . $e->getMessage()
            ], 500); // Provide error message
        }
    }
}
