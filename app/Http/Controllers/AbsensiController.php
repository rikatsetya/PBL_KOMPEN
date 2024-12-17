<?php

namespace App\Http\Controllers;

use App\Models\AbsensiModel;
use App\Models\MahasiswaModel;
use App\Models\PeriodeModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\DataTables;

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
        $activeMenu = 'daftar_alpha';
        $activeSubMenu = '';
        return view('daftar_alpha.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'activeSubMenu' => $activeSubMenu]);
    }

    public function list(Request $request)
    {
        $absensi = AbsensiModel::select('absensi_id', 'mahasiswa_id', 'periode_id', 'alpha', 'poin', 'status')
            ->with(['mahasiswa', 'periode']);
        return DataTables::of($absensi)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addColumn('aksi', function ($absensi) { // menambahkan kolom aksi 
                $btn  = '<button onclick="modalAction(\'' . url('/daftar_alpha/' . $absensi->absensi_id) . '\')" class="btn btn-info btn-sm" title="Detail Absensi">Detail</button>';
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
        $absensi = AbsensiModel::find($id);
        return view('daftar_alpha.show_ajax', ['absensi' => $absensi]);
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
        return view('daftar_alpha.import');
    }
    
    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi file
            $rules = [
                'file_absensi' => ['required', 'mimes:xlsx', 'max:1024'], // Validasi file xlsx, max 1MB
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $file = $request->file('file_absensi'); // Ambil file dari request
            $reader = IOFactory::createReader('Xlsx'); // Load reader file excel
            $reader->setReadDataOnly(true); // Hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // Load file excel
            $sheet = $spreadsheet->getActiveSheet(); // Ambil sheet yang aktif
            $data = $sheet->toArray(null, false, true, true); // Ambil data excel sebagai array

            $insert = [];
            if (count($data) > 1) { // Pastikan ada data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // Lewati baris pertama (header)

                        // Cari mahasiswa_id berdasarkan NIM
                        
                        // if (!$mahasiswaId) {
                        //     continue; // Lewati jika NIM tidak ditemukan
                        // }

                        // Cari periode_id berdasarkan nama periode
                        
                        // if (!$periodeId) {
                        //     continue; // Lewati jika periode tidak ditemukan
                        // }

                        // Siapkan data untuk insert
                        $insert[] = [
                            'nim' => $value['A'],
                            'alpha' => $value['B'],
                            'poin' => $value['C'],
                            'status' => $value['D'],
                            'periode' => $value['E'],
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    foreach ($insert as $key => $data) {
                        $mahasiswaId = MahasiswaModel::where('nim', $data['nim'])->value('mahasiswa_id');
                        $periodeId = PeriodeModel::where('periode_tahun', $data['periode'])->value('periode_id');
                        AbsensiModel::insertOrIgnore([
                            'mahasiswa_id' => $mahasiswaId,
                            'alpha' => $data['alpha'],
                            'poin' => $data['poin'],
                            'status' => $data['status'],
                            'periode_id' => $periodeId,
                            'created_at' => $data['created_at'],
                        ]);
                    }
                    // Insert data ke database, jika data sudah ada, maka diabaikan
                    

                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil diimport',
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Tidak ada data yang valid untuk diimport',
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport',
                ]);
            }
        }
        return redirect('/');
    }

    public function export_excel()
    {
        // ambil data absensi yang akan di export
        $absensi = AbsensiModel::select('absensi_id', 'mahasiswa_id', 'alpha', 'poin', 'status', 'periode_id')
            ->with('mahasiswa', 'periode')
            ->orderBy('mahasiswa_id')
            ->get();
        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Absensi ID');
        $sheet->setCellValue('C1', 'NIM');
        $sheet->setCellValue('D1', 'Nama Mahasiswa');
        $sheet->setCellValue('E1', 'Alpha');
        $sheet->setCellValue('F1', 'Poin');
        $sheet->setCellValue('G1', 'Status');
        $sheet->setCellValue('H1', 'Periode');
        $sheet->getStyle('A1:H1')->getFont()->setBold(true); // bold header
        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($absensi as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->absensi_id);
            $sheet->setCellValue('C' . $baris, $value->mahasiswa->nim);
            $sheet->setCellValue('D' . $baris, $value->mahasiswa->mahasiswa_nama);
            $sheet->setCellValue('E' . $baris, $value->alpha);
            $sheet->setCellValue('F' . $baris, $value->poin);
            $sheet->setCellValue('G' . $baris, $value->status);
            $sheet->setCellValue('H' . $baris, $value->periode->periode_tahun);
            $baris++;
            $no++;
        }
        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }
        $sheet->setTitle('Data absensi'); // set title sheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data absensi ' . date('Y-m-d H:i:s') . '.xlsx';
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
        $absensi = AbsensiModel::select('absensi_id', 'mahasiswa_id', 'alpha', 'poin', 'status', 'periode_id')
            ->with(['mahasiswa', 'periode']) 
            ->orderBy('absensi_id')
            ->get();

        $pdf = Pdf::loadView('daftar_alpha.export_pdf', ['absensi' => $absensi]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url 
        $pdf->render();
        return $pdf->stream('Data_Absensi_' . date('Y-m-d_H-i-s') . '.pdf');
    }

}
