<?php

namespace App\Http\Controllers;

use App\Models\JenisModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class JenisController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Jenis',
            'list' => ['Home', 'Jenis']
        ];
        $page = (object) [
            'title' => 'Daftar Jenis yang terdaftar dalam sistem'
        ];
        $activeMenu = 'detail';
        $activeSubMenu = 'jenis';
        return view('jenis.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'activeSubMenu'=> $activeSubMenu]);
    }

    public function list(Request $request)
    {
        $jenis = JenisModel::select('jenis_id', 'jenis_nama');
        return DataTables::of($jenis)
            ->addIndexColumn()
            ->addColumn('aksi', function ($jenis) {
                // $btn = '<button onclick="modalAction(\'' . url('/jenis/' . $jenis->jenis_id ) . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn = '<button onclick="modalAction(\'' . url('/jenis/' . $jenis->jenis_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jenis/' . $jenis->jenis_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) 
            ->make(true);
    }

    public function create_ajax()
    {
        return view('jenis.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'jenis_nama'    => 'required|string|min:3|unique:t_jenis_tugas,jenis_nama',
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'    => false, // response status, false: error/gagal, true: berhasil
                    'message'   => 'Validasi Gagal',
                    'msgField'  => $validator->errors(), // pesan error validasi
                ]);
            }
            JenisModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data Jenis berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    // Menampilkan detail jenis
    public function show(string $id)
    {
        $jenis = JenisModel::find($id);
        $breadcrumb = (object) ['title' => 'Detail Jenis', 'list' => ['Home', 'Jenis', 'Detail']];
        $page = (object) ['title' => 'Detail Jenis'];
        $activeMenu = 'jenis'; // set menu yang sedang aktif
        return view('jenis.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'jenis' => $jenis, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit jenis ajax
    public function edit_ajax(string $id)
    {
        $jenis = JenisModel::find($id);
        return view('jenis.edit_ajax', ['jenis' => $jenis]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'jenis_nama'    => 'required|string|min:3|unique:t_jenis_tugas,jenis_nama',
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }
            $check = JenisModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $jenis = JenisModel::find($id);
        return view('jenis.confirm_ajax', ['jenis' => $jenis]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $jenis = JenisModel::find($id);
            if ($jenis) {
                $jenis->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
}
