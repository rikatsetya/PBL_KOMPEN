<?php

namespace App\Http\Controllers;

use App\Models\PengumpulanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class UpdateKompenSelesaiMController extends Controller
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
        return view('kompen_selesai.indexm', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'activeSubMenu' => $activeSubMenu
        ]);
    }
    public function list(Request $request)
    {
        $selesai = PengumpulanModel::with(['tugas', 'mahasiswa'])
            ->select('pengumpulan_id', 'tugas_id', 'mahasiswa_id', 'foto_sebelum', 'foto_sesudah', 'tanggal', 'status', 'alasan')
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
            ->make(true);
    }
}
