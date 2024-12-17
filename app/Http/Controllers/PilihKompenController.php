<?php

namespace App\Http\Controllers;

use App\Models\JenisModel;
use App\Models\TugasModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Services\DataTable;

class PilihKompenController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Tugas Kompen',
            'list' => ['home', 'Pilih Kompen']
        ];
        $page = (object) [
            'title' => 'Daftar Tugas yang Dapat Diambil'
        ];
        $activeMenu = 'pilihkompen';
        $activeSubMenu = '';
        $jenis = JenisModel::all();
        return view('pilihkompen.index', 
        [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'activeMenu' => $activeMenu, 
            'jenis' => $jenis,
            'activeSubMenu' => $activeSubMenu
        ]);
    }

    public function list(Request $request)
    {
        $tugas = TugasModel::select(
            'tugas_id',
            't_tugas.jenis_id', 
            'm_user.user_id',
            'm_user.level_id', 
            'tugas_nama', 
            'deskripsi', 
            'tugas_bobot', 
            'kuota', 
            'tugas_tenggat', 
            'periode_id',
            't_jenis_tugas.jenis_nama'
        )
        ->join('m_user', 't_tugas.user_id', '=','m_user.user_id')->with('jenis')->with('user')
        ->leftJoin('t_jenis_tugas', 't_tugas.jenis_id', '=', 't_jenis_tugas.jenis_id');

        if ($request->jenis_id) {
            $tugas->where('t_tugas.jenis_id', $request->jenis_id);
        }
        return DataTables::of($tugas)
        ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
        ->addColumn('aksi', function ($tugas) {
            $btn  = '<button onclick="modalAction(\'' . url('/pilihkompen/' . $tugas->tugas_id . '/show_ajax') . '\')" class="btn btn-info btn-sm" title="Detail tugas">Ambil</button>';
            return $btn;
        })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
        ->make(true);
    }

    public function show_ajax(string $id)
    {
        $tugas = TugasModel::select('tugas_id','jenis_id', 'm_user.user_id','m_user.level_id', 'tugas_nama', 'deskripsi', 'tugas_bobot', 'kuota', 'tugas_tenggat', 'periode_id')->join('m_user', 't_tugas.user_id', '=','m_user.user_id')->with('jenis')->with('user')->find($id);
        $breadcrumb = (object) ['title' => 'Detail Tugas', 'list' => ['home', 'Dafar Tugas', 'Detail']];
        $page = (object) ['title' => 'Detail Tugas'];
        $activeMenu = 'pilihkompen';
        $activeSubMenu = '';
        return view('pilihkompen.show_ajax', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'activeSubMenu' => $activeSubMenu, 'tugas' => $tugas]);
    }
}