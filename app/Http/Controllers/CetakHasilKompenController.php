<?php

namespace App\Http\Controllers;

use App\Models\AbsensiModel;
use App\Models\MahasiswaModel;
use App\Models\PeriodeModel;
use App\Models\SuratModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class CetakHasilKompenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Hasil Kompen',
            'list' => ['Home', 'hasil kompen']
        ];
        $page = (object) [
            'title' => 'Daftar Hasil Kompen Mahasiswa yang terdaftar dalam sistem'
        ];
        $activeMenu = 'hasil';
        $activeSubMenu = '';

        // Get all periods
        $periode = PeriodeModel::all();
        $user = UserModel::all();

        return view('hasil_kompen.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'activeSubMenu' => $activeSubMenu,
            'periode' => $periode
        ]);
    }

    public function list(Request $request)
    {
        // Get the current logged-in user
        $user = Auth::user();

        // Get the mahasiswa_id from the logged-in user
        $mahasiswa = MahasiswaModel::where('username', $user->username)->first();

        if (!$mahasiswa) {
            return response()->json(['error' => 'Mahasiswa tidak ditemukan'], 404);
        }

        // Query for absensi data related to the logged-in mahasiswa
        $hasil = AbsensiModel::select('t_absensi_mhs.mahasiswa_id', 't_absensi_mhs.absensi_id', 't_absensi_mhs.poin', 't_absensi_mhs.status', 't_absensi_mhs.periode_id')
            ->leftJoin('t_surat_kompen', 't_surat_kompen.mahasiswa_id', '=', 't_absensi_mhs.mahasiswa_id')
            ->with('mahasiswa', 'periode') // Include related mahasiswa and periode models
            ->where('t_absensi_mhs.mahasiswa_id', $mahasiswa->mahasiswa_id); // Filter by mahasiswa_id

        // Apply filters based on status and periode_id if provided
        if ($request->status) {
            $hasil->where('t_absensi_mhs.status', $request->status);
        }
        if ($request->periode_id) {
            $hasil->where('t_absensi_mhs.periode_id', $request->periode_id);
        }
        if ($request->surat_uuid) {
            $hasil->where('t_surat_kompen.surat_uuid', $request->surat_uuid);
        }

        // Return data in DataTables format
        return DataTables::of($hasil)
            ->addIndexColumn() // Automatically adds the 'DT_RowIndex' column
            ->addColumn('aksi', function ($hasil) { // Add action column
                if ($hasil->status == 'Lunas') {
                    return '<a href="' . url('/hasil/' . $hasil->absensi_id) . '" class="btn btn-success btn-sm">Cetak</a>';
                    // return '<a href="#!" onClick="openPdf('.$hasil->absensi_id.', '.$hais.')" class="btn btn-success btn-sm">Cetak</a>';
                }
                return ''; // Empty if status is not 'Lunas'
            })
            ->rawColumns(['aksi']) // Indicate that 'aksi' column contains HTML
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
        //
    }
    public function import_ajax(Request $request)
    {
        //
    }
    public function export_excel()
    {
        // 
    } // end function export_excel
    public function export_pdf($id)
    {
        // Ambil data berdasarkan ID absensi
        $hasil = AbsensiModel::with('mahasiswa', 'periode')->find($id);

        if (!$hasil) {
            // Jika data tidak ditemukan, alihkan dengan pesan error
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $surat_kompen = SuratModel::where('mahasiswa_id', $hasil->mahasiswa_id)
            ->where('absensi_id', $hasil->absensi_id)
            ->first();
        if (!$surat_kompen) {
            $surat_kompen = new SuratModel();
            $surat_kompen->surat_uuid = Str::uuid();
            $surat_kompen->mahasiswa_id = $hasil->mahasiswa_id;
            $surat_kompen->absensi_id = $hasil->absensi_id;
            $surat_kompen->tanggal_pengajuan = Carbon::now()->toDateString();
            $surat_kompen->save();
        } else if (!$surat_kompen->surat_uuid) {
            $surat_kompen->surat_uuid = Str::uuid();
            $surat_kompen->save();
        }
        $hasil['surat_kompen'] = $surat_kompen;

        $filePath = 'qrcodes/' . $hasil['surat_kompen']->surat_uuid . '.svg'; // Path where the QR code will be saved
        Storage::disk('public')->put($filePath, QrCode::size(300)->generate($hasil['surat_kompen']->surat_uuid));

        // $svgContent = file_get_contents("storage/$filePath"); // Read the SVG content from the file
        // $base64Svg = base64_encode($svgContent);
        $hasil['qrcode'] = "storage/$filePath";

        // Buat PDF menggunakan DomPDF
        $pdf = Pdf::loadView('hasil_kompen.export_pdf', ['hasil' => $hasil]);
        $pdf->setPaper('a4', 'portrait'); // Set ukuran kertas dan orientasi
        return $pdf->stream('Hasil Kompen Mahasiswa ' . $hasil->mahasiswa->nim . '.pdf');
    }
}
