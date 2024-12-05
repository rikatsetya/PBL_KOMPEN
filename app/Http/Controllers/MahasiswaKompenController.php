<?php

namespace App\Http\Controllers;

use App\Models\AbsensiMahasiswaModel;
use App\Models\MahasiswaModel; // Pastikan model ini ada
use App\Models\PeriodeModel; // Pastikan model ini ada
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaKompenController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Mahasiswa Kompen',
            'list' => ['Home', 'Mahasiswa Kompen']
        ];

        $page = (object) [
            'title' => 'Daftar Mahasiswa Kompen yang terdaftar dalam sistem'
        ];

        $activeMenu = 'mahasiswa';

        // Mengambil data mahasiswa dan periode
        $mahasiswa = AbsensiMahasiswaModel::with('mahasiswa', 'periode')->get();
        return view('mahasiswa.index', compact('breadcrumb', 'page', 'mahasiswa', 'activeMenu'));
    }

    public function list(Request $request)
    {
        try {
            // Mengambil data absensi mahasiswa dengan relasi mahasiswa dan periode
            $mahasiswa = AbsensiMahasiswaModel::with('mahasiswa', 'periode')
                ->orderBy('absensi_id');

            // Filter berdasarkan mahasiswa_id jika ada
            if ($request->mahasiswa_id) {
                $mahasiswa->where('mahasiswa_id', $request->mahasiswa_id);
            }

            return DataTables::of($mahasiswa)
                ->addIndexColumn()
                ->addColumn('periode', function ($row) {
                    // Pastikan untuk mengakses 'periode_tahun' dari relasi periode
                    return $row->periode ? $row->periode->periode_tahun : '-';
                })
                ->addColumn('aksi', function ($row) {
                    // Tombol aksi
                    return '<button onclick="modalAction(\'' . url('/mahasiswa/' . $row->absensi_id) . '\')" class="btn btn-info btn-sm" title="Detail">Detail</button>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching data: ' . $e->getMessage()]);
        }
    }


    public function show($id)
    {
        // Memuat relasi mahasiswa dan periode
        $mahasiswa = AbsensiMahasiswaModel::with('mahasiswa', 'periode')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Mahasiswa Kompen',
            'list' => ['Home', 'Mahasiswa', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Mahasiswa Kompen'
        ];

        $activeMenu = 'mahasiswa';

        return view('mahasiswa.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'mahasiswa' => $mahasiswa, // Pastikan variabel ini diubah menjadi mahasiswa
            'activeMenu' => $activeMenu
        ]);
    }

    public function export_excel()
    {
        try {
            // Aktifkan output buffering untuk mencegah output sebelum header
            ob_start();

            // Ambil data absensi mahasiswa beserta relasi mahasiswa dan periode
            $absensi = AbsensiMahasiswaModel::select('mahasiswa_id', 'poin', 'periode_id')
                ->orderBy('mahasiswa_id')
                ->with('mahasiswa', 'periode')
                ->get();

            // Membuat spreadsheet baru
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Menambahkan header kolom
            $sheet->setCellValue('A1', 'No');
            $sheet->setCellValue('B1', 'NIM');
            $sheet->setCellValue('C1', 'Nama Mahasiswa');
            $sheet->setCellValue('D1', 'Poin');
            $sheet->setCellValue('E1', 'Periode');
            $sheet->getStyle('A1:E1')->getFont()->setBold(true);

            // Mengisi data ke dalam spreadsheet
            $no = 1;
            $baris = 2;
            foreach ($absensi as $value) {
                $sheet->setCellValue('A' . $baris, $no); // No
                $sheet->setCellValue('B' . $baris, $value->mahasiswa->nim); // NIM mahasiswa
                $sheet->setCellValue('C' . $baris, $value->mahasiswa->mahasiswa_nama); // Nama mahasiswa
                $sheet->setCellValue('D' . $baris, $value->poin); // Poin mahasiswa
                $sheet->setCellValue('E' . $baris, $value->periode->periode_tahun); // Tahun periode
                $baris++;
                $no++;
            }

            // Menyesuaikan lebar kolom agar otomatis
            foreach (range('A', 'E') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }

            // Mengatur judul sheet
            $sheet->setTitle('Data Kompen Mahasiswa');

            // Menyiapkan file untuk diekspor
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $filename = 'Data_Kompen_Mahasiswa_' . date('Y-m-d_H:i:s') . '.xlsx';

            // Header untuk download file Excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Last-Modified:' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');

            // Output file Excel
            $writer->save('php://output');

            // Matikan buffer dan hentikan script
            ob_end_clean();
            exit;
        } catch (\Exception $e) {
            // Tangani error jika ada
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function export_pdf()
    {
        // Ambil data absensi beserta relasi mahasiswa dan periode
        $mahasiswa = AbsensiMahasiswaModel::with(['mahasiswa', 'periode'])
            ->select('absensi_id', 'mahasiswa_id', 'periode_id', 'alpha', 'poin', 'status')
            ->orderBy('mahasiswa_id')
            ->get();

        // Load tampilan untuk PDF
        $pdf = Pdf::loadView('mahasiswa.export_pdf', ['mahasiswa' => $mahasiswa]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);

        // Stream atau unduh file PDF
        return $pdf->stream('Data_Absensi_Mahasiswa_' . date('Y-m-d_H:i:s') . '.pdf');
    }
}
