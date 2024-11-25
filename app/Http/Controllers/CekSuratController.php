<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaKompenModel;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;

class CetakSuratController extends Controller
{
    public function index()
    {
        $activeMenu = 'cetak';
        $breadcrumb = (object)[
            'title' => 'Data Mahasiswa Kompen',
            'list' => ['Home', 'cetak']
        ];
        $mahasiswa = MahasiswaModel::select('mahasiswa_id', 'mahasiswa_nama')->get();

        return view('cetak.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            'mahasiswa' => $mahasiswa
        ]);
    }

    public function list(Request $request)
    {
        $mahasiswa_id = $request->input('filter_mahasiswa');

        $cetak = MahasiswaKompenModel::with('mahasiswa') // Memuat relasi mahasiswa
            ->select('mahasiswa_id', 'sakit', 'izin', 'alpha', 'poin', 'status', 'periode')
            ->when($mahasiswa_id, function ($query) use ($mahasiswa_id) {
                $query->where('mahasiswa_id', $mahasiswa_id);
            });

        return DataTables::of($cetak)
            ->addIndexColumn()
            ->addColumn('mahasiswa_nama', function ($cetak) {
                return $cetak->mahasiswa->mahasiswa_nama ?? 'Tidak tersedia';
            })
            ->addColumn('aksi', function ($cetak) {
                $requestUrl = url('/cetak/request/' . $cetak->mahasiswa_id);
                $cetakUrl = url('/cetak/cetak/' . $cetak->mahasiswa_id);
                $btn = '
                <a href="' . $requestUrl . '" class="btn btn-primary btn-sm">Request</a>
                <a href="' . $cetakUrl . '" class="btn btn-warning btn-sm">Cetak</a>
            ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function request($id)
    {
        $mahasiswa = MahasiswaKompenModel::with('mahasiswa')->find($id);

        if (!$mahasiswa) {
            return redirect()->route('cetak.index')->with('error', 'Data tidak ditemukan.');
        }

        // Tambahkan logika request di sini (misalnya, ubah status atau tambahkan data ke log request)
        // Contoh: ubah status menjadi "Diminta"
        $mahasiswa->status = 'Diminta';
        $mahasiswa->save();

        return redirect()->route('cetak.index')->with('success', 'Request berhasil diproses.');
    }

    public function cetak($id)
    {
        $mahasiswa = MahasiswaKompenModel::with('mahasiswa')->find($id);

        if (!$mahasiswa) {
            return redirect()->route('cetak.index')->with('error', 'Data tidak ditemukan.');
        }

        $pdf = Pdf::loadView('cetak.file_pdf', ['mahasiswa' => $mahasiswa]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Cetak Mahasiswa Kompen ' . $mahasiswa->mahasiswa->mahasiswa_nama . '.pdf');
    }
}
