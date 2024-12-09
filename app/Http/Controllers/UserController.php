<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\DosenModel;
use App\Models\LevelModel;
use App\Models\TendikModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\DataTables;


class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];
        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];
        $activeMenu = 'pengguna';
        $activeSubMenu = 'user';
        $level = LevelModel::all(); // ambil data level untuk filter level
        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu, 'activeSubMenu' => $activeSubMenu]);
    }

    // Ambil data user dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $user = UserModel::select('user_id', 'username', 'nama', 'level_id')
            ->with('level')
            ->where('level_id', '!=', 5);

        if ($request->level_id) {
            $user->where('level_id', $request->level_id);
        }
        return DataTables::of($user)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addColumn('aksi', function ($user) {
                $btn = '<button onclick="modalAction(\'' . url('/user/' . $user->user_id) . '\')" class="btn btn-info btn-sm">detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }

    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.create_ajax')
            ->with('level', $level);
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id'  => 'required|integer',
                'no_induk'  => 'required|integer',
                'username'  => 'required|string|min:3|unique:m_user,username',
                'nama'      => 'required|string|max:100',
                'password'  => 'required|min:6'
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
            $request['foto'] = "images/profile/default.jpg";
            $userId = UserModel::insertGetId([
                'level_id' => $request->level_id,
                'username' => $request->username,
                'nama' => $request->nama,
                'password' => bcrypt($request->password),
            ]);
            $request['user_id'] = $userId;
            switch ($request->level_id) {
                case '1':
                    AdminModel::create([
                        'user_id' => $request->user_id,
                        'no_induk' => $request->no_induk,
                        'username' => $request->username,
                        'admin_nama' => $request->nama,
                        'foto' => $request->foto,
                        'password' => bcrypt($request->password),
                    ]);
                    break;

                case '2':
                    DosenModel::create([
                        'user_id' => $request->user_id,
                        'nip' => $request->no_induk,
                        'username' => $request->username,
                        'dosen_nama' => $request->nama,
                        'foto' => $request->foto,
                        'password' => bcrypt($request->password),
                    ]);
                    break;

                case '3':
                    TendikModel::create([
                        'user_id' => $request->user_id,
                        'no_induk' => $request->no_induk,
                        'username' => $request->username,
                        'tendik_nama' => $request->nama,
                        'foto' => $request->foto,
                        'password' => bcrypt($request->password),
                    ]);
                    break;
            }
            return response()->json([
                'status'    => true,
                'message'   => 'Data user berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    // Menampilkan detail user
    public function show(string $id)
    {
        $users = UserModel::with('level')->find($id);
        switch ($users->level_id) {
            case '1':
                $user = AdminModel::select('m_level.level_nama', 'm_level.level_id', 'm_user.level_id', 'm_admin.username', 'm_admin.admin_nama', 'm_admin.foto', 'm_admin.no_induk', 'm_admin.password')
                    ->join('m_user', 'm_admin.user_id', '=', 'm_user.user_id')
                    ->join('m_level', 'm_user.level_id', '=', 'm_level.level_id')
                    ->where('m_user.user_id', $id)
                    ->first();
                return view('user.show', ['user' => $user]);
                break;
            case '2':
                $user = DosenModel::select('m_level.level_nama', 'm_level.level_id', 'm_user.level_id', 'm_dosen.username', 'm_dosen.dosen_nama', 'm_dosen.foto', 'm_dosen.nip', 'm_dosen.password')
                    ->join('m_user', 'm_dosen.user_id', '=', 'm_user.user_id')
                    ->join('m_level', 'm_user.level_id', '=', 'm_level.level_id')
                    ->where('m_user.user_id', $id)
                    ->first();
                return view('user.show', ['user' => $user]);
                break;
            case '3':
                $user = TendikModel::select('m_level.level_nama', 'm_level.level_id', 'm_user.level_id', 'm_tendik.username', 'm_tendik.tendik_nama', 'm_tendik.foto', 'm_tendik.no_induk', 'm_tendik.password')
                    ->join('m_user', 'm_tendik.user_id', '=', 'm_user.user_id')
                    ->join('m_level', 'm_user.level_id', '=', 'm_level.level_id')
                    ->where('m_user.user_id', $id)
                    ->first();
                return view('user.show', ['user' => $user]);
                break;

            default:
                # code...
                break;
        }
    }

    // Menampilkan halaman form edit user ajax
    public function edit_ajax(string $id)
    {
        $users = UserModel::with('level')->find($id);
        switch ($users->level_id) {
            case '1':
                $level = LevelModel::select('level_id', 'level_nama')->get();
                $user = AdminModel::select('m_level.level_nama', 'm_level.level_id', 'm_user.level_id', 'm_user.user_id', 'm_admin.username', 'm_admin.admin_nama', 'm_admin.foto', 'm_admin.no_induk', 'm_admin.password')
                    ->join('m_user', 'm_admin.user_id', '=', 'm_user.user_id')
                    ->join('m_level', 'm_user.level_id', '=', 'm_level.level_id')
                    ->where('m_user.user_id', $id)
                    ->first();
                return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
                break;
            case '2':
                $level = LevelModel::select('level_id', 'level_nama')->get();
                $user = DosenModel::select('m_level.level_nama', 'm_level.level_id', 'm_user.level_id', 'm_user.user_id', 'm_dosen.username', 'm_dosen.dosen_nama', 'm_dosen.foto', 'm_dosen.nip', 'm_dosen.password')
                    ->join('m_user', 'm_dosen.user_id', '=', 'm_user.user_id')
                    ->join('m_level', 'm_user.level_id', '=', 'm_level.level_id')
                    ->where('m_user.user_id', $id)
                    ->first();
                return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
                break;
            case '3':
                $level = LevelModel::select('level_id', 'level_nama')->get();
                $user = TendikModel::select('m_level.level_nama', 'm_level.level_id', 'm_user.level_id', 'm_user.user_id', 'm_tendik.username', 'm_tendik.tendik_nama', 'm_tendik.foto', 'm_tendik.no_induk', 'm_tendik.password')
                    ->join('m_user', 'm_tendik.user_id', '=', 'm_user.user_id')
                    ->join('m_level', 'm_user.level_id', '=', 'm_level.level_id')
                    ->where('m_user.user_id', $id)
                    ->first();
                return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
                break;

            default:
                # code...
                break;
        }
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id'  => 'required|integer',
                'no_induk'  => 'required|integer',
                'username'  => 'nullable|string|min:3|unique:m_user,username',
                'nama'      => 'required|string|max:100',
                'password'  => 'nullable|min:6',
                'foto'      => 'nullable|mimes:jpeg,png,jpg|max:4096'
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
            $check = UserModel::find($id);
            if ($check) {
                if (!$request->filled('username')) { // jika password tidak diisi, maka hapus dari request
                    $request->request->remove('username');
                }
                if (!$request->filled('password')) { // jika password tidak diisi, maka hapus dari request
                    $request->request->remove('password');
                }
                if (!$request->filled('foto')) { // jika password tidak diisi, maka hapus dari request 
                    $request->request->remove('foto');
                }
                if (isset($check->foto)) {
                    $fileold = $check->foto;
                    if (Storage::disk('public')->exists($fileold)) {
                        Storage::disk('public')->delete($fileold);
                    }
                    if ($request->has('foto')) {
                        $file = $request->file('foto');
                        $filename = $check->foto;
                        $path = 'image/profile/';
                        $file->move($path, $filename);
                        $pathname = $filename;
                        $request['foto'] = $pathname;
                    }
                } else {
                    if ($request->has('foto')) {
                        $file = $request->file('foto');
                        $extension = $file->getClientOriginalExtension();

                        $filename = time() . '.' . $extension;

                        $path = 'image/profile/';
                        $file->move($path, $filename);
                        $pathname = $path . $filename;
                        $request['foto'] = $pathname;
                    }
                }
                switch ($request->level_id) {
                    case '1':
                        $admin = AdminModel::where('user_id', $id)->first();
                        $admin->update($request->all());
                        break;

                    case '2':
                        $dosen = DosenModel::where('user_id', $id)->first();
                        $request['nip'] = $request->no_induk;
                        $request->request->remove('no_induk');
                        $dosen->update($request->all());
                        break;

                    case '3':
                        $tendik = TendikModel::where('user_id', $id)->first();
                        $tendik->update($request->all());
                        break;
                }
                $request->request->remove('no_induk');
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
        $user = UserModel::find($id);
        return view('user.confirm_ajax', ['user' => $user]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);
            if ($user) {
                $user->delete();
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

    public function import()
    {
        return view('user.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_user' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_user'); // ambil file dari request
            $reader = IOFactory::createReader('Xlsx'); // load reader file excel
            $reader->setReadDataOnly(true); // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel
            $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
            $data = $sheet->toArray(null, false, true, true); // ambil data excel
            $insert = [];
            if (count($data) > 1) { // jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // baris ke 1 adalah header, maka lewati
                        switch ($value['A']) {
                            case 'admin':
                                $insert[] = [
                                    'level_id' => '1',
                                    'username' => $value['B'],
                                    'nama' => $value['C'],
                                    'no_induk' => $value['D'],
                                    'password' => bcrypt($value['E']),
                                    'foto' => 'images/profile/default.jpg',
                                    'created_at' => now(),
                                ];
                                break;

                            case 'dosen':
                                $insert[] = [
                                    'level_id' => '2',
                                    'username' => $value['B'],
                                    'nama' => $value['C'],
                                    'no_induk' => $value['D'],
                                    'password' => bcrypt($value['E']),
                                    'foto' => 'images/profile/default.jpg',
                                    'created_at' => now(),
                                ];
                                break;

                            case 'tendik':
                                $insert[] = [
                                    'level_id' => '3',
                                    'username' => $value['B'],
                                    'nama' => $value['C'],
                                    'no_induk' => $value['D'],
                                    'password' => bcrypt($value['E']),
                                    'foto' => 'images/profile/default.jpg',
                                    'created_at' => now(),
                                ];
                                break;

                            default:
                                # code...
                                break;
                        }
                    }
                }
                if (count($insert) > 0) {
                    foreach ($insert as $data) {
                        UserModel::insertOrIgnore([
                            'level_id' => $data['level_id'],
                            'username' => $data['username'],
                            'nama' => $data['nama'],
                            'password' => $data['password'],
                            'created_at' => $data['created_at'],
                        ]);

                        $userId = UserModel::where('username', $data['username'])->value('user_id');

                        // Handle related models based on level_id
                        switch ($data['level_id']) {
                            case '1': // Admin
                                AdminModel::insertOrIgnore([
                                    'user_id' => $userId,
                                    'username' => $data['username'],
                                    'admin_nama' => $data['nama'],
                                    'no_induk' => $data['no_induk'],
                                    'password' => $data['password'],
                                    'foto' => $data['foto'],
                                    'created_at' => $data['created_at'],
                                ]);
                                break;
                            case '2': // Dosen
                                DosenModel::insertOrIgnore([
                                    'user_id' => $userId,
                                    'username' => $data['username'],
                                    'dosen_nama' => $data['nama'],
                                    'nip' => $data['no_induk'],
                                    'password' => $data['password'],
                                    'foto' => $data['foto'],
                                    'created_at' => $data['created_at'],
                                ]);
                                break;
                            case '3': // Tendik
                                TendikModel::insertOrIgnore([
                                    'user_id' => $userId,
                                    'username' => $data['username'],
                                    'tendik_nama' => $data['nama'],
                                    'no_induk' => $data['no_induk'],
                                    'password' => $data['password'],
                                    'foto' => $data['foto'],
                                    'created_at' => $data['created_at'],
                                ]);
                                break;
                            default:
                                // Handle unexpected level_id if needed
                                break;
                        }
                    }
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/');
    }

    public function export_excel()
    {
        // ambil data user yang akan di export
        $admin = AdminModel::select('m_user.user_id', 'no_induk', 'm_user.username', 'm_user.nama', 'm_level.level_nama', 'm_user.level_id')
            ->join('m_user', 'm_admin.user_id', '=', 'm_user.user_id')
            ->join('m_level', 'm_user.level_id', '=', 'm_level.level_id')
            ->orderBy('user_id')
            ->get();
        $dosen = DosenModel::select('m_user.user_id', 'nip', 'm_user.username', 'm_user.nama', 'm_level.level_nama', 'm_user.level_id')
            ->join('m_user', 'm_dosen.user_id', '=', 'm_user.user_id')
            ->join('m_level', 'm_user.level_id', '=', 'm_level.level_id')
            ->orderBy('user_id')
            ->get();
        $tendik = TendikModel::select('m_user.user_id', 'no_induk', 'm_user.username', 'm_user.nama', 'm_level.level_nama', 'm_user.level_id')
            ->join('m_user', 'm_tendik.user_id', '=', 'm_user.user_id')
            ->join('m_level', 'm_user.level_id', '=', 'm_level.level_id')
            ->orderBy('user_id')
            ->get();

        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'level');
        $sheet->setCellValue('C1', 'No_Induk');
        $sheet->setCellValue('D1', 'Username');
        $sheet->setCellValue('E1', 'Nama user');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true); // bold header
        
        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($admin as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->level_nama); // ambil nama kategori
            $sheet->setCellValue('C' . $baris, $value->no_induk);
            $sheet->setCellValue('D' . $baris, $value->username);
            $sheet->setCellValue('E' . $baris, $value->nama);
            $baris++;
            $no++;
        }
        foreach ($dosen as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->level_nama); // ambil nama kategori
            $sheet->setCellValue('C' . $baris, $value->nip);
            $sheet->setCellValue('D' . $baris, $value->username);
            $sheet->setCellValue('E' . $baris, $value->nama);
            $baris++;
            $no++;
        }
        foreach ($tendik as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->level_nama); // ambil nama kategori
            $sheet->setCellValue('C' . $baris, $value->no_induk);
            $sheet->setCellValue('D' . $baris, $value->username);
            $sheet->setCellValue('E' . $baris, $value->nama);
            $baris++;
            $no++;
        }

        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }

        $sheet->setTitle('Data user'); // set title sheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data user ' . date('Y-m-d H:i:s') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified:' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer->save('php://output');
        exit;
    } // end function export_excel

    public function export_pdf()
    {
        $admin = AdminModel::select('m_user.user_id', 'no_induk', 'm_user.username', 'm_user.nama', 'm_level.level_nama', 'm_user.level_id')
            ->join('m_user', 'm_admin.user_id', '=', 'm_user.user_id')
            ->join('m_level', 'm_user.level_id', '=', 'm_level.level_id')
            ->orderBy('user_id')
            ->get();
        $dosen = DosenModel::select('m_user.user_id', 'nip', 'm_user.username', 'm_user.nama', 'm_level.level_nama', 'm_user.level_id')
            ->join('m_user', 'm_dosen.user_id', '=', 'm_user.user_id')
            ->join('m_level', 'm_user.level_id', '=', 'm_level.level_id')
            ->orderBy('user_id')
            ->get();
        $tendik = TendikModel::select('m_user.user_id', 'no_induk', 'm_user.username', 'm_user.nama', 'm_level.level_nama', 'm_user.level_id')
            ->join('m_user', 'm_tendik.user_id', '=', 'm_user.user_id')
            ->join('m_level', 'm_user.level_id', '=', 'm_level.level_id')
            ->orderBy('user_id')
            ->get();

        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('user.export_pdf', ['admin' => $admin, 'dosen' => $dosen, 'tendik' => $tendik]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url $pdf->render();
        return $pdf->stream('Data user' . date('Y-m-d H:i:s') . '.pdf');
    }
}
