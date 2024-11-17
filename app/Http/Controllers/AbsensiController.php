<?php

namespace App\Http\Controllers;

use App\Models\AbsensiModel;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Absensi',
            'list' => ['Home', 'user']
        ];

        $page = (object) [
            'title' => 'Daftar Absensi Mahasiswa Alpha yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user'; // set menu yang sedang aktif

        // $supplier = SupplierModel::all(); // ambil data supplier untuk filter supplier
        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);    

        // $data = MahasiswaModel::select(
        //     'm_mahasiswa.mahasiswa_id', 
        //     'nim', 
        //     'username', 
        //     'mahasiswa_nama', 
        //     'password', 
        //     'foto', 
        //     'no_telp', 
        //     'jurusan', 
        //     'prodi', 
        //     'kelas',
        //     't_absensi_mhs.sakit', 
        //     't_absensi_mhs.izin', 
        //     't_absensi_mhs.alpha', 
        //     't_absensi_mhs.poin', 
        //     't_absensi_mhs.status', 
        //     't_absensi_mhs.periode'
        // )
        // ->leftJoin('t_absensi_mhs', 'm_mahasiswa.mahasiswa_id', '=', 't_absensi_mhs.mahasiswa_id')
        // ->get();
    
        // return response()->json($data);

    }

    public function list(Request $request)
    {
        $supplier = AbsensiModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat');
        // Filter data supplier berdasarkan supplier_id
        // if ($request->supplier_id) {
        //     $supplier->where('supplier_id', $request->supplier_id);
        // }
        return DataTables::of($supplier)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addColumn('aksi', function ($supplier) { // menambahkan kolom aksi 
                $btn = '<a href="' . url('/supplier/' . $supplier->supplier_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
                'file_absensi' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_absensi'); // ambil file dari request
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
                            'mahasiswa_id' => $value['A'],
                            'sakit' => $value['B'],
                            'izin' => $value['C'],
                            'alpha' => $value['D'],
                            'poin' => $value['E'],
                            'status' => $value['F'],
                            'periode' => $value['G'],
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    AbsensiModel::insertOrIgnore($insert);
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
        // ambil data supplier yang akan di export
        $supplier = AbsensiModel::select('absensi_id','mahasiswa_id', 'mahasiswa.mahasiswa_nama', 'sakit','izin','alpha','poin','status','periode')
            ->orderBy('absensi_id')
            ->get();
        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Absensi ID');
        $sheet->setCellValue('C1', 'Mahasiswa ID');
        $sheet->setCellValue('D1', 'Nama Mahasiswa');
        $sheet->setCellValue('E1', 'Sakit');
        $sheet->setCellValue('F1', 'Izin');
        $sheet->setCellValue('G1', 'Alpha');
        $sheet->setCellValue('H1', 'Poin');
        $sheet->setCellValue('I1', 'Status');
        $sheet->setCellValue('J1', 'Periode');
        $sheet->getStyle('A1:J1')->getFont()->setBold(true); // bold header
        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($supplier as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->absensi_id);
            $sheet->setCellValue('C' . $baris, $value->mahasiswa_id);
            $sheet->setCellValue('D' . $baris, $value->mahasiswa->mahasiswa_nama);
            $sheet->setCellValue('E' . $baris, $value->sakit);
            $sheet->setCellValue('F' . $baris, $value->izin);
            $sheet->setCellValue('G' . $baris, $value->alpha);
            $sheet->setCellValue('H' . $baris, $value->poin);
            $sheet->setCellValue('I' . $baris, $value->status);
            $sheet->setCellValue('J' . $baris, $value->periode);
            $baris++;
            $no++;
        }
        foreach (range('A', 'J') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }
        $sheet->setTitle('Data Absensi'); // set title sheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data supplier ' . date('Y-m-d H:i:s') . '.xlsx';
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
        $user = AbsensiModel::select('absensi_id', 'mahasiswa_id','mahasiswa.mahasiswa_nama','sakit','izin','alpha','poin','status','periode')
            ->orderBy('absensi_id')
            ->get();
        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('user.export_pdf', ['user' => $user]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url $pdf->render();
        return $pdf->stream('Data absensi' . date('Y-m-d H:i:s') . '.pdf');
    }
}