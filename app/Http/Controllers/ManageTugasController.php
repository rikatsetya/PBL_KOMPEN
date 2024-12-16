<?php

namespace App\Http\Controllers;

use App\Models\JenisModel;
use App\Models\LevelModel;
use App\Models\PeriodeModel;
use App\Models\TugasModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ManageTugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Tugas',
            'list' => ['Home', 'Tugas']
        ];
        $page = (object) [
            'title' => 'Daftar Tugas yang terdaftar dalam sistem'
        ];
        $activeMenu = 'tugas';
        $activeSubMenu = '';
        $user = UserModel::all();
        $jenis = JenisModel::all();
        return view('tugas.index', 
        [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'activeMenu' => $activeMenu, 
            'user' => $user,
            'jenis.jenis_nama' => $jenis,
            'activeSubMenu' => $activeSubMenu
        ]);
    }

    public function list(Request $request)
    {
        $user = Auth::user();

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
        ->leftJoin('t_jenis_tugas', 't_tugas.jenis_id', '=', 't_jenis_tugas.jenis_id')
        ->where('m_user.user_id', $user->user_id)
        ->get();

        return DataTables::of($tugas)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addColumn('aksi', function ($tugas) {
                $btn  = '<button onclick="modalAction(\'' . url('/manage_tugas/' . $tugas->tugas_id . '/show_ajax') . '\')" class="btn btn-info btn-sm" title="Detail tugas">Detail</button>';
                $btn .= ' <button onclick="modalAction(\'' . url('/manage_tugas/' . $tugas->tugas_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm" title="Edit tugas">Edit</button>';
                $btn .= ' <button onclick="modalAction(\'' . url('/manage_tugas/' . $tugas->tugas_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm" title="Hapus tugas">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create_ajax()
    {
        $jenis = JenisModel::select('jenis_id', 'jenis_nama')->get();
        $user = UserModel::select('user_id', 'username')->get();
        $periode = PeriodeModel::select('periode_id', 'periode_tahun')->get();

        return view('tugas.create_ajax')
            ->with('jenis', $jenis)
            ->with('user', $user)
            ->with('periode', $periode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_ajax(Request $request)
    {
        // Cek apakah request berupa Ajax
        if ($request->ajax() || $request->wantsJson()) {
            // Aturan validasi
            $rules = [
                'jenis_id' => 'required|integer',
                'tugas_nama' => 'required|string|max:255',
                'deskripsi' => 'required|min:1',
                'tugas_bobot' => 'required|integer',
                'kuota' => 'required|integer',
                'tugas_tenggat' => 'required|string',
                'periode_id' => 'required',
            ];

            // Menggunakan Validator untuk memvalidasi input
            $validator = Validator::make($request->all(), $rules);

            // Jika validasi gagal, kembalikan respon JSON dengan pesan error
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors() // pesan error validasi
                ]);
            }
            $user = Auth::user();
            $request['user_id'] = $user->user_id;
            // Jika validasi berhasil, simpan data user
            TugasModel::create($request -> all());

            // Kembalikan respon JSON berhasil
            return response()->json([
                'status' => true,
                'message' => 'Data tugas berhasil disimpan',
            ]);
        }

        // Jika bukan request Ajax, redirect ke halaman utama
        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show_ajax(string $id)
    {
        $tugas = TugasModel::select('tugas_id','jenis_id', 'm_user.user_id','m_user.level_id', 'tugas_nama', 'deskripsi', 'tugas_bobot', 'kuota', 'tugas_tenggat', 'periode_id')->join('m_user', 't_tugas.user_id', '=','m_user.user_id')->with('jenis')->with('user')->find($id);
        $breadcrumb = (object) ['title' => 'Daftar Tugas', 'list' => ['Home', 'Daftar Tugas', 'Detail']];
        $page = (object) ['title' => 'Daftar Tugas'];
        $activeMenu = 'tugas';
        $activeSubMenu = '';
        return view('tugas.show_ajax', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'activeSubMenu' => $activeSubMenu, 'tugas' => $tugas]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit_ajax(string $id)
    {
        // Retrieve the user by ID, or return a 404 if not found
        $tugas = TugasModel::findOrFail($id);

        $jenis = JenisModel::select('jenis_id', 'jenis_nama')->get();
        $user = UserModel::select('user_id', 'username')->get();

        // Return the edit view with user and levels data
        return view('tugas.edit_ajax', [
            'tugas' => $tugas,
            'jenis' => $jenis,
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'user_id' => 'nullable|integer',
                'jenis_id' => 'required|integer',
                'tugas_nama' => 'required|string|max:255',
                'deskripsi' => 'required|min:1',
                'tugas_bobot' => 'required|integer',
                'tugas_tenggat' => 'required|string',
                'periode' => 'required|string',
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal!',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = TugasModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diperbarui!'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan!'
                ]);
            }
        }

        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $tugas = TugasModel::find($id);
        return view('tugas.confirm_ajax', ['tugas' => $tugas]);
    }

    //Menghapus data stok AJAX
    public function delete_ajax(Request $request, string $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $tugas = TugasModel::find($id);
            if ($tugas) {
                $tugas->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus!'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan!'
                ]);
            }
        }

        return redirect('/');
    }
}