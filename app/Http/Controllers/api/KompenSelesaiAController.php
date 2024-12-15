<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\PengumpulanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KompenSelesaiAController extends Controller
{
    public function showAllData()
    {
        // Ambil semua data pengumpulan tugas beserta tugas dan mahasiswa

        $user = Auth::user();

        $data = PengumpulanModel::with(['tugas', 'mahasiswa'])
            ->whereHas('tugas', function ($query) use ($user) {
                $query->where('user_id', $user->user_id);
            })
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    // Menampilkan detail tugas berdasarkan pengumpulan_id
    public function showTaskDetail(Request $request)
    {
        $user = Auth::user();
        $id = $request->input('pengumpulan_id');

        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'Pengumpulan ID tidak ditemukan'
            ], 400);
        }

        $taskDetail = PengumpulanModel::with(['tugas', 'mahasiswa'])
            ->where('pengumpulan_id', $id)
            ->whereHas('tugas', function ($query) use ($user) {
                $query->where('user_id', $user->user_id); // Filter berdasarkan user_id di tabel tugas
            })
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


    // Mengupdate status dan alasan
    public function updateStatusAndReason(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:terima,tolak',
            'alasan' => 'required_if:status,tolak|string|max:255',
            'pengumpulan_id' => 'required|integer',
        ]);

        $user = Auth::user();

        $task = PengumpulanModel::where('pengumpulan_id', $validated['pengumpulan_id'])
            ->whereHas('tugas', function ($query) use ($user) {
                $query->where('user_id', $user->user_id); // Filter berdasarkan user_id di tabel tugas
            })
            ->first();

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found or not associated with the current user'
            ], 404);
        }

        $task->status = $validated['status'];

        if ($validated['status'] === 'tolak') {
            $task->alasan = $validated['alasan'];
        } else {
            $task->alasan = null;
        }

        $task->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully'
        ]);
    }
}
