<?php

namespace App\Http\Controllers;

use App\Models\PengumpulanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        $selesai = PengumpulanModel::with(['tugas', 'mahasiswa'])
            ->select('pengumpulan_id', 'tugas_id', 'mahasiswa_id', 'foto_sebelum', 'foto_sesudah', 'tanggal', 'status')
            ->get();

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
                // Button for editing
                return '<button onclick="modalAction(\'' . url('/kompen_selesai/' . $selesai->pengumpulan_id . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button>
                        <a href="'. url('/kompen_selesai/' . $selesai->pengumpulan_id . '/detail') . '" class="btn btn-info btn-sm">Detail</a>';
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

    // Handle status update and reject reason if applicable
    public function update(Request $request, string $id)
    {
        $selesai = PengumpulanModel::find($id);

        // Validate the form inputs
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:terima,tolak',
            'alasan' => 'required_if:status,tolak|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update the status and reason (if rejected)
        $selesai->status = $request->input('status');
        if ($request->input('status') == 'tolak') {
            $selesai->alasan = $request->input('alasan');
        }

        // Save the changes
        $selesai->save();

        return redirect()->route('kompen_selesai.index')->with('success', 'Status berhasil diperbarui!');
    }
}
