<?php

namespace App\Http\Controllers;

use App\Models\AbsensiModel;
use App\Models\MahasiswaModel;
use App\Models\PeriodeModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CetakHasilKompenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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

        // Mencari mahasiswa berdasarkan username dari user yang login
        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->first();

        // Jika mahasiswa tidak ditemukan, kembalikan error
        if (!$mahasiswa) {
            return response()->json(['error' => 'Mahasiswa tidak ditemukan'], 404);
        }

        // Query for absensi data related to the logged-in mahasiswa
        $hasil = AbsensiModel::select('mahasiswa_id', 'absensi_id', 'poin', 'status', 'periode_id')
            ->with('mahasiswa', 'periode') // Include related mahasiswa and periode models
            ->where('mahasiswa_id', $mahasiswa->mahasiswa_id); // Filter by mahasiswa_id

        // Apply filters based on status and periode_id if provided
        if ($request->status) {
            $hasil->where('status', $request->status);
        }
        if ($request->periode_id) {
            $hasil->where('periode_id', $request->periode_id);
        }

        // Return data in DataTables format
        return DataTables::of($hasil)
            ->addIndexColumn() // Automatically adds the 'DT_RowIndex' column
            ->addColumn('aksi', function ($hasil) { // Add action column
                if ($hasil->status == 'Lunas') {
                    return '<a href="' . url('/hasil/' . $hasil->absensi_id) . '" class="btn btn-success btn-sm">Cetak</a>';
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

        // Periksa jika data ditemukan
        if (!$hasil) {
            // Jika data tidak ditemukan, alihkan dengan pesan error
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // Buat PDF menggunakan DomPDF
        $pdf = Pdf::loadView('hasil_kompen.export_pdf', ['hasil' => $hasil]);
        $pdf->setPaper('a4', 'portrait'); // Set ukuran kertas dan orientasi
        
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url 
        $pdf->render();
        return $pdf->stream('Hasil Kompen Mahasiswa ' . $hasil->mahasiswa->nim . '.pdf');
    }
}