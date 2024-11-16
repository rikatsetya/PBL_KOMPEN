<?php

namespace App\Http\Controllers;

use App\Models\KompetensiModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\DataTables;

class KompetensiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kompetensi',
            'list' => ['Home', 'Kompetensi']
        ];
        $page = (object) [
            'title' => 'Daftar Kompetensi yang terdaftar dalam sistem'
        ];
        $activeMenu = 'detail';
        $activeSubMenu = 'kompetensi';
        return view('kompetensi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'activeSubMenu'=> $activeSubMenu]);
    }

    public function list(Request $request)
    {
        $kompetensi = KompetensiModel::select('kompetensi_id','kompetensi_nama','kompetensi_deskripsi');
        return DataTables::of($kompetensi)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kompetensi) {
                $btn = '<button onclick="modalAction(\'' . url('/kompetensi/' . $kompetensi->kompetensi_id ) . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kompetensi/' . $kompetensi->kompetensi_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kompetensi/' . $kompetensi->kompetensi_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) 
            ->make(true);
    }

    public function create_ajax()
    {
        return view('kompetensi.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kompetensi_nama'       => 'required|string|min:3|unique:t_kompetensi,kompetensi_nama',
                'kompetensi_deskripsi'  => 'required|string|max:100',
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
            KompetensiModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data kompetensi berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    // Menampilkan detail kompetensi
    public function show(string $id)
    {
        $kompetensi = KompetensiModel::find($id);
        $breadcrumb = (object) ['title' => 'Detail kompetensi', 'list' => ['Home', 'Lekompetensivel', 'Detail']];
        $page = (object) ['title' => 'Detail kompetensi'];
        $activeMenu = 'kompetensi'; // set menu yang sedang aktif
        return view('kompetensi.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kompetensi' => $kompetensi, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit kompetensi ajax
    public function edit_ajax(string $id)
    {
        $kompetensi = KompetensiModel::find($id);
        return view('kompetensi.edit_ajax', ['kompetensi' => $kompetensi]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kompetensi_nama'       => 'required|string|min:3|unique:t_kompetensi,kompetensi_nama',
                'kompetensi_deskripsi'  => 'required|string|max:100',
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
            $check = KompetensiModel::find($id);
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
        $kompetensi = KompetensiModel::find($id);
        return view('kompetensi.confirm_ajax', ['kompetensi' => $kompetensi]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $kompetensi = KompetensiModel::find($id);
            if ($kompetensi) {
                $kompetensi->delete();
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
        return view('kompetensi.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_kompetensi' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_kompetensi'); // ambil file dari request
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
                            'kompetensi_nama' => $value['A'],
                            'kompetensi_deskripsi' => $value['B'],
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    KompetensiModel::insertOrIgnore($insert);
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
        // ambil data kompetensi yang akan di export
        $kompetensi = KompetensiModel::select('kompetensi_nama', 'kompetensi_deskripsi')
            ->orderBy('kompetensi_nama')
            ->get();

        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'nama kompetensi');
        $sheet->setCellValue('C1', 'deskripsi kompetensi');

        $sheet->getStyle('A1:C1')->getFont()->setBold(true); // bold header

        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($kompetensi as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->kompetensi_nama);
            $sheet->setCellValue('C' . $baris, $value->kompetensi_deskripsi);
            $baris++;
            $no++;
        }

        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }

        $sheet->setTitle('Data kompetensi'); // set title sheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data kompetensi ' . date('Y-m-d H:i:s') . '.xlsx';
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
        $kompetensi = KompetensiModel::select('kompetensi_nama', 'kompetensi_deskripsi')
            ->orderBy('kompetensi_nama')
            ->get();
        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('kompetensi.export_pdf', ['kompetensi' => $kompetensi]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url $pdf->render();
        return $pdf->stream('Data kompetensi' . date('Y-m-d H:i:s') . '.pdf');
    }
}
