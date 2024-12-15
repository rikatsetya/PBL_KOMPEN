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

class AbsensiKompenController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kompen',
            'list' => ['Home', 'kompen']
        ];
        $page = (object) [
            'title' => 'Daftar Kompen Mahasiswa yang terdaftar dalam sistem'
        ];
        $activeMenu = 'kompen';
        $activeSubMenu = '';

        $mahasiswa = MahasiswaModel::all();
        $periode = PeriodeModel::all();
        return view('daftar_kompen.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'activeSubMenu' => $activeSubMenu,
            'mahasiswa' => $mahasiswa,
            'periode' => $periode // Kirim data absensi ke view
        ]);
    }

    public function list(Request $request)
    {
        // Ambil data absensi dengan relasi mahasiswa dan periode
        $kompen = AbsensiModel::select('mahasiswa_id', 'absensi_id', 'poin', 'status', 'periode_id')
            ->with(['mahasiswa', 'periode']); // Menghapus titik koma yang salah di sini

        // Filter berdasarkan mahasiswa_id jika ada
        if ($request->mahasiswa_id) {
            $kompen->where('mahasiswa_id', $request->mahasiswa_id);
        }

        // Kembalikan data dalam format yang diminta oleh DataTables
        return DataTables::of($kompen)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->make(true); // Hapus bagian 'addColumn' untuk menghilangkan kolom aksi
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
        //
    }
    public function import_ajax(Request $request)
    {
        //
    }
    public function export_excel()
    {
        // ambil data user yang akan di export
        $kompen = AbsensiModel::select('mahasiswa_id', 'status', 'poin', 'periode_id')
            ->orderBy('mahasiswa_id')
            ->with('mahasiswa', 'periode')
            ->get();

        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'NIM');
        $sheet->setCellValue('C1', 'Nama Mahasiswa');
        $sheet->setCellValue('D1', 'Poin');
        $sheet->setCellValue('E1', 'Status');
        $sheet->setCellValue('F1', 'Periode');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true); // bold header

        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($kompen as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->mahasiswa->nim);
            $sheet->setCellValue('C' . $baris, $value->mahasiswa->mahasiswa_nama);
            $sheet->setCellValue('D' . $baris, $value->poin);
            $sheet->setCellValue('E' . $baris, $value->status); // ambil nama kategori
            $sheet->setCellValue('F' . $baris, $value->periode->periode_tahun); // ambil nama kategori
            $baris++;
            $no++;
        }

        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }

        $sheet->setTitle('Data kompen'); // set title sheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data kompen ' . date('Y-m-d H:i:s') . '.xlsx';
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
        $kompen = AbsensiModel::select('mahasiswa_id', 'poin', 'status', 'periode_id')
            ->orderBy('mahasiswa_id')
            ->with(['mahasiswa', 'periode'])
            ->get();
        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('daftar_kompen.export_pdf', ['kompen' => $kompen]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi 
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url 
        $pdf->render();
        return $pdf->stream('Data_kompen_' . date('Y-m-d H:i:s') . '.pdf');
    }
}
