<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaKompenModel;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class MahasiswaKompenController extends Controller
{
    public function index()
    {
        $activeMenu = 'mahasiswakmp';
        $breadcrumb = (object)[
            'title' => 'Data Mahasiswa Kompen',
            'list' => ['Home', 'mahasiswakmp']
        ];
        $page = (object) [
            'title' => 'Daftar Mahasiswa Kompen'
        ];
        $mahasiswa = MahasiswaModel::select('mahasiswa_id', 'mahasiswa_nama')->get();

        return view('mahasiswakmp.index', [
            'activeMenu' => $activeMenu,
            'page' => $page,
            'breadcrumb' => $breadcrumb,
            'mahasiswa' => $mahasiswa
        ]);
    }

    public function list(Request $request)
    {
        $mahasiswa_id = $request->input('filter_mahasiswa');

        $mahasiswakmp = MahasiswaKompenModel::with('mahasiswa') // Memuat relasi mahasiswa
            ->select('mahasiswa_id', 'sakit', 'izin', 'alpha', 'poin', 'status', 'periode')
            ->when($mahasiswa_id, function ($query) use ($mahasiswa_id) {
                $query->where('mahasiswa_id', $mahasiswa_id);
            });

        return DataTables::of($mahasiswakmp)
            ->addIndexColumn()
            ->addColumn('mahasiswa_nama', function ($mahasiswakmp) {
                return $mahasiswakmp->mahasiswa->mahasiswa_nama ?? 'Tidak tersedia';
            })
            ->addColumn('aksi', function ($mahasiswakmp) {
                $btn = '<a href="' . url('/mhskmp/' . $mahasiswakmp->mahasiswa_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show($id)
    {
        $mahasiswa = MahasiswaKompenModel::with('mahasiswa')->find($id);

        if (!$mahasiswa) {
            return redirect()->route('mahasiswakmp.index')->with('error', 'Data Mahasiswa Kompen tidak ditemukan');
        }

        // Sisanya tetap sama
        $activeMenu = 'mahasiswakmp';
        $breadcrumb = (object)[
            'title' => 'Detail Mahasiswa Kompen',
            'list' => ['Home', 'mahasiswakmp', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Data Mahasiswa Kompen'
        ];

        return view('mahasiswakmp.show', compact('mahasiswa', 'activeMenu', 'breadcrumb', 'page'));
    }



    public function export_excel()
    {
        // Ambil data mahasiswa kompen beserta relasi mahasiswa
        $mahasiswakmp = MahasiswaKompenModel::with('mahasiswa')
            ->select('mahasiswa_id', 'poin', 'status', 'periode')
            ->orderBy('mahasiswa_id')
            ->get();

        // Membuat spreadsheet baru
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menambahkan header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Mahasiswa');
        $sheet->setCellValue('C1', 'Poin');
        $sheet->setCellValue('D1', 'Status');
        $sheet->setCellValue('E1', 'Periode');
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

        // Mengisi data ke dalam spreadsheet
        $no = 1;
        $baris = 2;

        foreach ($mahasiswakmp as $key => $data) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $data->mahasiswa->mahasiswa_nama);
            $sheet->setCellValue('C' . $baris, $data->poin);
            $sheet->setCellValue('D' . $baris, $data->status);
            $sheet->setCellValue('E' . $baris, $data->periode);

            $baris++;
            $no++;
        }

        // Mengatur ukuran kolom agar otomatis menyesuaikan
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Membuat file Excel
        $sheet->setTitle('Data Mahasiswa Kompen');
        $writer = new Xlsx($spreadsheet);
        $filename = 'Data Mahasiswa Kompen' . date('Y-m-d_H-i-s') . '.xlsx';

        // Mengatur header untuk download file
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
    }


    public function export_pdf()
    {
        $mahasiswakmp = MahasiswaKompenModel::select('mahasiswa_id', 'sakit', 'izin', 'alpha', 'poin', 'status', 'periode', 'mahasiswa_nama')
            ->orderBy('mahasiswa_id')
            ->with('mahasiswa')
            ->get();

        $pdf = Pdf::loadView('mahasiswakmp.export_pdf', ['mahasiswakmp' => $mahasiswakmp]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Mahasiswa Kompen' . date('Y-m-d H:i:s') . '.pdf');
    }
}
