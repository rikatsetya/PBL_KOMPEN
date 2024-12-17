<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\DataTables;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Mahasiswa',
            'list' => ['Home', 'Mahasiswa']
        ];
        $page = (object) [
            'title' => 'Daftar mahasiswa yang terdaftar dalam sistem'
        ];
        $activeMenu = 'mahasiswa';
        $activeSubMenu = '';
        return view('mahasiswa.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeSubMenu' => $activeSubMenu, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $mahasiswa = MahasiswaModel::select('mahasiswa_id', 'nim', 'username', 'mahasiswa_nama', 'foto', 'jurusan', 'prodi','kelas');

        return DataTables::of($mahasiswa)
            ->addIndexColumn()
            ->addColumn('aksi', function ($mahasiswa) {
                $btn = '<button onclick="modalAction(\'' . url('/mahasiswa/' . $mahasiswa->mahasiswa_id) . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/mahasiswa/' . $mahasiswa->mahasiswa_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/mahasiswa/' . $mahasiswa->mahasiswa_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }
    public function create_ajax()
    {
        return view('mahasiswa.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nim'               => 'required|integer',
                'username'          => 'required|string|min:3|unique:m_user,username',
                'mahasiswa_nama'    => 'required|string|max:100',
                'password'          => 'required|min:6',
                'no_telp'           => 'required|integer',
                'jurusan'           => 'required|string',
                'prodi'             => 'required|string',
                'kelas'             => 'required|string'
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
            $request['foto']= "images/profile/default.jpg";
            MahasiswaModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data mahasiswa berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    // Menampilkan detail user
    public function show(string $id)
    {
        $mahasiswa = MahasiswaModel::find($id);
        $breadcrumb = (object) ['title' => 'Detail User', 'list' => ['Home', 'User', 'Detail']];
        $page = (object) ['title' => 'Detail user'];
        $activeMenu = 'mahasiswa';
        return view('mahasiswa.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'mahasiswa' => $mahasiswa, 'activeMenu' => $activeMenu]);
    }

    public function edit_ajax(string $id)
    {
        $mahasiswa = MahasiswaModel::find($id);
        return view('mahasiswa.edit_ajax', ['mahasiswa' => $mahasiswa]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nim'               => 'nullable|integer',
                'username'          => 'nullable|string|min:3|unique:m_user,username',
                'mahasiswa_nama'    => 'required|string|max:100',
                'password'          => 'nullable|min:6',
                'no_telp'           => 'required|integer',
                'jurusan'           => 'required|string',
                'prodi'             => 'required|string',
                'kelas'             => 'required|string',
                'foto'              => 'nullable|mimes:jpeg,png,jpg|max:4096'
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
            $check = MahasiswaModel::find($id);
            if ($check) {
                if (!$request->filled('nim')) { // jika password tidak diisi, maka hapus dari request
                    $request->request->remove('nim');
                }
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
                        $request['foto']= $pathname;
                    }
                } else {
                    if ($request->has('foto')) {
                        $file = $request->file('foto');
                        $extension = $file->getClientOriginalExtension();

                        $filename = time() . '.' . $extension;

                        $path = 'image/profile/';
                        $file->move($path, $filename);
                        $pathname = $path . $filename;
                        $request['foto']= $pathname;
                    }
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
        $mahasiswa = MahasiswaModel::find($id);
        return view('mahasiswa.confirm_ajax', ['mahasiswa' => $mahasiswa]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $mahasiswa = MahasiswaModel::find($id);
            if ($mahasiswa) {
                $mahasiswa->delete();
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
        return view('mahasiswa.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_mahasiswa' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_mahasiswa'); // ambil file dari request
            $reader = IOFactory::createReader('Xlsx'); // load reader file excel
            $reader->setReadDataOnly(true); // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel
            $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
            $data = $sheet->toArray(null, false, true, true); // ambil data excel
            $insert = [];
            if (count($data) > 1) { // jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // baris ke 1 adalah header, maka lewati
                        $insert[] = [
                            'nim'               => $value['A'],
                            'username'          => $value['B'],
                            'nama'              => $value['C'],
                            'password'          => bcrypt($value['D']),
                            'no_telp'           => '-',
                            'jurusan'           => $value['E'],
                            'prodi'             => $value['F'],
                            'kelas'             => $value['G'],
                            'foto'              => 'images/profile/default.jpg',
                            'created_at'        => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    foreach ($insert as $key => $data) {
                        UserModel::insertOrIgnore([
                            'level_id'               => '5',
                            'username'          => $data['username'],
                            'nama'      => $data['nama'],
                            'password'          => $data['password'],
                            'created_at'        => $data['created_at'],
                        ]);

                        $userId = UserModel::where('username', $data['username'])->value('user_id');
                        MahasiswaModel::insertOrIgnore([
                            'user_id'           => $userId,
                            'username'          => $data['username'],
                            'mahasiswa_nama'    => $data['nama'],
                            'password'          => $data['password'],
                            'nim'               => $data['nim'],
                            'no_telp'           => $data['no_telp'],
                            'jurusan'           => $data['jurusan'],
                            'prodi'             => $data['prodi'],
                            'kelas'             => $data['kelas'],
                            'foto'              => $data['foto'],
                            'created_at'        => $data['created_at'],
                        ]);
                    }
                    // insert data ke database, jika data sudah ada, maka diabaikan
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
        $mahasiswa = MahasiswaModel::select('mahasiswa_id', 'nim', 'username', 'mahasiswa_nama', 'foto', 'jurusan', 'prodi','kelas')
            ->orderBy('nim')
            ->get();

        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'nim');
        $sheet->setCellValue('C1', 'username');
        $sheet->setCellValue('D1', 'mahasiswa_nama');
        $sheet->setCellValue('E1', 'jurusan');
        $sheet->setCellValue('F1', 'prodi');
        $sheet->setCellValue('G1', 'kelas');

        $sheet->getStyle('A1:G1')->getFont()->setBold(true); // bold header

        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($mahasiswa as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->nim);
            $sheet->setCellValue('C' . $baris, $value->username);
            $sheet->setCellValue('D' . $baris, $value->mahasiswa_nama);
            $sheet->setCellValue('E' . $baris, $value->jurusan);
            $sheet->setCellValue('F' . $baris, $value->prodi);
            $sheet->setCellValue('G' . $baris, $value->kelas);
            $baris++;
            $no++;
        }

        foreach (range('A', 'G') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }

        $sheet->setTitle('Data Mahasiswa'); // set title sheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Mahasiswa ' . date('Y-m-d H:i:s') . '.xlsx';
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
        $mahasiswa = MahasiswaModel::select('mahasiswa_id', 'nim', 'username', 'mahasiswa_nama', 'foto', 'jurusan', 'prodi','kelas')
            ->orderBy('nim')
            ->get();
        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('mahasiswa.export_pdf', ['mahasiswa' => $mahasiswa]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url 
        $pdf->render();
        return $pdf->stream('Data Mahasiswa' . date('Y-m-d H:i:s') . '.pdf');
    }
}
