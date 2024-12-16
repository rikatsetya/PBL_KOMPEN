<?php

namespace App\Http\Controllers;

use App\Models\PengumpulanModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class UpdateKompenSelesaiAController extends Controller
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
        return view('kompen_selesai.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'activeSubMenu' => $activeSubMenu
        ]);
    }

    // List of tasks with necessary fields (tugas_nama, mahasiswa_nama, tanggal, status)
    public function list(Request $request)
    {
        // Get the currently authenticated user
        $user = Auth::user();

        if (!($user->level_id == 1 || $user->level_id == 2 || $user->level_id == 3)) {
            return response()->json(['error' => 'Access denied'], 403);
        }

        $selesai = PengumpulanModel::with(['tugas', 'mahasiswa'])
            ->whereHas('tugas', function ($query) use ($user) {
                $query->where('user_id', $user->user_id);
            })
            ->get();


        // Return data as DataTable response
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
            ->addColumn('aksi', function ($selesai) {
                return '<button onclick="modalAction(\'' . url('/kompen_selesai/' . $selesai->pengumpulan_id . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button>
                        <a href="' . url('/kompen_selesai/' . $selesai->pengumpulan_id . '/detail') . '" class="btn btn-info btn-sm">Detail</a>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // Show form to update foto_sebelum, foto_sesudah, and status
    public function edit(string $id)
    {
        $selesai = PengumpulanModel::find($id);
        return view('kompen_selesai.edit', ['selesai' => $selesai]);
    }

    // Show detailed information of the selected task
    public function detail(string $id)
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
        $selesai = PengumpulanModel::with(['tugas', 'mahasiswa'])->find($id);
        return view('kompen_selesai.detail', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'selesai' => $selesai,
            'activeMenu' => $activeMenu,
            'activeSubMenu' => $activeSubMenu
        ]);
    }

    public function update(Request $request, string $id)
    {
        $selesai = PengumpulanModel::find($id);

        // Validate the form inputs
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:terima,tolak',
            'alasan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()->all()], 422);
        }

        // Update the status and reason (if rejected)
        $selesai->status = $request->input('status');
        if ($request->input('status') == 'tolak') {
            $selesai->alasan = $request->input('alasan');
        }

        // Save the changes
        $selesai->save();

        return response()->json(['status' => 'success', 'message' => 'Status berhasil diperbarui!']);
    }
}