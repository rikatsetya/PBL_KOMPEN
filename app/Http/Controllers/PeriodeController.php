<?php

namespace App\Http\Controllers;

use App\Models\PeriodeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class PeriodeController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Daftar Periode',
            'list' => ['Home', 'Periode']
        ];
        $page = (object) [
            'title' => 'Daftar Periode yang terdaftar dalam sistem'
        ];
        $activeMenu = 'detail';
        $activeSubMenu = 'periode';
        return view('periode.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'activeSubMenu'=> $activeSubMenu]);
    }

    public function list(Request $request)
    {
        $periode = PeriodeModel::select('periode_id', 'periode_tahun', 'periode_semester');
        return DataTables::of($periode)
            ->addIndexColumn()
            ->addColumn('aksi', function ($periode) {
                $btn = '<button onclick="modalAction(\'' . url('/periode/' . $periode->periode_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/periode/' . $periode->periode_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) 
            ->make(true);
    }

    public function create_ajax()
    {
        return view('periode.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'periode_tahun'    => 'required|string|min:3|unique:t_periode,periode_tahun',
                'periode_semester' => 'required|in:ganjil,genap',
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
            PeriodeModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data periode berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    // Menampilkan halaman form edit periode ajax
    public function edit_ajax(string $id)
    {
        $periode = PeriodeModel::find($id);
        return view('periode.edit_ajax', ['periode' => $periode]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'periode_tahun'    => 'nullable|string|min:3|unique:t_periode,periode_tahun',
                'periode_semester' => 'required|in:ganjil,genap',
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
            $check = PeriodeModel::find($id);
            if ($check) {
                if (!$request->filled('periode_tahun')) { // jika password tidak diisi, maka hapus dari request
                    $request->request->remove('periode_tahun');
                }

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
        $periode = PeriodeModel::find($id);
        return view('periode.confirm_ajax', ['periode' => $periode]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $periode = PeriodeModel::find($id);
            if ($periode) {
                $periode->delete();
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
