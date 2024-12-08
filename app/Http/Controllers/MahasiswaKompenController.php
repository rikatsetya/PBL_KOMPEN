<?php

namespace App\Http\Controllers;

use App\Models\AbsensiModel;
use App\Models\MahasiswaKompenModel;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;

class MahasiswaKompenController extends Controller
{
    public function index()
    {
        $activeMenu = 'mhs';
        $activeSubMenu = '';
        $breadcrumb = (object)[
            'title' => 'Data Mahasiswa Kompen',
            'list' => ['Home', 'mhs']
        ];
        $mahasiswa = MahasiswaModel::select('mahasiswa_id', 'mahasiswa_nama')->get();

        return view('mhs.index', [
            'activeMenu' => $activeMenu,
            'activeSubMenu' => $activeSubMenu,
            'breadcrumb' => $breadcrumb,
            'mahasiswa' => $mahasiswa
        ]);
    }

    public function list(Request $request)
{
    $mahasiswa_id = $request->input('filter_mahasiswa');

    $mhs = AbsensiModel::with('mahasiswa') // Memuat relasi mahasiswa
        ->select('mahasiswa_id', 'alpha', 'poin', 'status', 'periode_id')
        ->when($mahasiswa_id, function ($query) use ($mahasiswa_id) {
            $query->where('mahasiswa_id', $mahasiswa_id);
        });

    return DataTables::of($mhs)
        ->addIndexColumn()
        ->addColumn('mahasiswa_nama', function ($mhs) {
            // Mengambil nama mahasiswa dari relasi
            return $mhs->mahasiswa->mahasiswa_nama ?? 'Tidak tersedia';
        })
        ->addColumn('aksi', function ($mhs) {
            $btn = '<button onclick="modalAction(\'' . url('/mhs/' . $mhs->mahasiswa_id ) . '\')" class="btn btn-info btn-sm">Detail</button> ';
            return $btn;
                // <button onclick="modalAction(\'' . url('mhs.edit_ajax', $id) . '\')" class="btn btn-warning btn-sm">Edit</button>
                // <button onclick="modalAction(\'' . url('mhs.delete_ajax', $id) . '\')" class="btn btn-danger btn-sm">Hapus</button>
            })
        ->rawColumns(['aksi'])
        ->make(true);
}


    public function show(string $id)
    {
        $mhs = AbsensiModel::with('mahasiswa')->find($id); // Load relasi mahasiswa
        $breadcrumb = (object) ['title' => 'Detail Mahasiswa Kompen', 'list' => ['Home', 'Mahasiswa Kompen', 'Detail']];
        $page = (object) ['title' => 'Detail Mahasiswa Kompen'];
        $activeMenu = 'mahasiswa';

        return view('mhs.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'mhs' => $mhs,
            'activeMenu' => $activeMenu
        ]);
    }

    public function create_ajax()
    {
        $mahasiswa = MahasiswaModel::select('mahasiswa_id', 'mahasiswa_nama')->get();
        return view('mhs.create_ajax')->with('mahasiswa', $mahasiswa);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'mahasiswa_id'  => 'required|integer',
                'sakit'         => 'required|integer|min:0',
                'izin'          => 'required|integer|min:0',
                'alpha'         => 'required|integer|min:0',
                'poin'          => 'required|integer|min:0',
                'status'        => 'required|string',
                'periode'       => 'required|string|min:4'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            AbsensiModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    public function edit_ajax($id)
    {
        $mhs = AbsensiModel::find($id);
        $level = MahasiswaModel::select('mahasiswa_id', 'mahasiswa_nama')->get();

        return view('mhs.edit_ajax', ['mhs' => $mhs]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'mahasiswa_id'  => 'required|integer',
                'sakit'         => 'required|integer|min:0',
                'izin'          => 'required|integer|min:0',
                'alpha'         => 'required|integer|min:0',
                'poin'          => 'required|integer|min:0',
                'status'        => 'required|string',
                'periode'       => 'required|string|min:4'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = AbsensiModel::find($id);

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

    public function confirm_ajax($id)
    {
        $mhs = AbsensiModel::find($id);
        return view('mhs.confirm_ajax', ['mhs' => $mhs]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $mhs = AbsensiModel::find($id);

            if ($mhs) {
                $mhs->delete();
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
        return view('mhs.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_mhs' => ['required', 'mimes:xlsx', 'max:1024'] // Validasi file xlsx max 1MB
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_mhs');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);
            $insert = [];

            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $insert[] = [
                            'mahasiswa_id' => $value['A'],
                            'sakit' => $value['B'],
                            'izin' => $value['C'],
                            'alpha' => $value['D'],
                            'poin' => $value['E'],
                            'status' => $value['F'],
                            'created_at' => now()
                        ];
                    }
                }

                if (count($insert) > 0) {
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
        // Ambil data mhs yang akan diekspor
        $mhs = AbsensiModel::select('mahasiswa_id', 'sakit', 'izin', 'alpha', 'poin', 'status', 'periode')
            ->orderBy('mahasiswa_id')
            ->with('mahasiswa')
            ->get();

        // Load library PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // Ambil sheet yang aktif

        // Set header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Sakit');
        $sheet->setCellValue('D1', 'Izin');
        $sheet->setCellValue('E1', 'Alpha');
        $sheet->setCellValue('F1', 'Poin');
        $sheet->setCellValue('G1', 'Status');
        $sheet->setCellValue('H1', 'Periode');
        $sheet->getStyle('A1:H1')->getFont()->setBold(true); // Bold header

        $no = 1; // Nomor data dimulai dari 1
        $baris = 2; // Baris data dimulai dari baris ke 2

        // Loop data mhs dan masukkan ke dalam sheet
        foreach ($mhs as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->mahasiswa_id);
            $sheet->setCellValue('C' . $baris, $value->sakit);
            $sheet->setCellValue('D' . $baris, $value->izin);
            $sheet->setCellValue('E' . $baris, $value->alpha);
            $sheet->setCellValue('F' . $baris, $value->poin); // Ambil nama kategori
            $sheet->setCellValue('G' . $baris, $value->status); // Ambil nama kategori
            $sheet->setCellValue('H' . $baris, $value->periode); // Ambil nama kategori
            $baris++;
            $no++;
        }

        // Set auto size untuk kolom A sampai F
        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Set judul sheet
        $sheet->setTitle('Data mhs');

        // Membuat writer untuk menulis file Excel
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_mhs_' . date('Y-m-d_H-i-s') . '.xlsx';

        // Set header untuk download file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1'); // Bypass cache IE
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Expired date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // Always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        // Simpan file ke output
        $writer->save('php://output');
        exit;
    }
    public function export_pdf()
    {
        // Ambil data mhs yang akan diekspor
        $mhs = AbsensiModel::select('mahasiswa_id', 'sakit', 'izin', 'alpha', 'poin', 'status', 'periode')
            ->orderBy('mahasiswa_id')
            ->with('mahasiswa')
            ->get();

        // Menggunakan Barryvdh\DomPDF\Facade\Pdf untuk membuat PDF
        $pdf = Pdf::loadView('mhs.export_pdf', ['mhs' => $mhs]);

        // Set ukuran kertas dan orientasi
        $pdf->setPaper('a4', 'portrait');

        // Set opsi jika ada gambar dari URL, set true
        $pdf->setOption("isRemoteEnabled", true);

        // Render PDF
        $pdf->render();

        // Mengembalikan file PDF yang dihasilkan dalam bentuk stream
        return $pdf->stream('Data_mhs_' . date('Y-m-d H:i:s') . '.pdf');
    }
}