<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = MahasiswaModel::select(
            'm_mahasiswa.mahasiswa_id',
            'nim',
            'username',
            'mahasiswa_nama',
            'foto',
            'no_telp',
            'jurusan',
            'prodi',
            'kelas',
            't_absensi_mhs.alpha',
            't_absensi_mhs.poin',
            't_absensi_mhs.status',
            't_periode.periode_tahun',
            't_periode.periode_semester'
        )
            ->leftJoin('t_absensi_mhs', 'm_mahasiswa.mahasiswa_id', '=', 't_absensi_mhs.mahasiswa_id')
            ->leftJoin('t_periode', 't_absensi_mhs.periode_id','=', 't_periode.periode_id')
            ->where('t_absensi_mhs.alpha', '!=', '0')
            ->get();

        return response()->json([
            'success'   => true,
            'data'      => $data
        ]);
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
    public function show(Request $request)
    {

        $id = $request->input('id');

        $data = MahasiswaModel::select(
            'm_mahasiswa.mahasiswa_id',
            'nim',
            'username',
            'mahasiswa_nama',
            'foto',
            'no_telp',
            'jurusan',
            'prodi',
            'kelas',
            't_absensi_mhs.alpha',
            't_absensi_mhs.poin',
            't_absensi_mhs.status',
        )
            ->leftJoin('t_absensi_mhs', 'm_mahasiswa.mahasiswa_id', '=', 't_absensi_mhs.mahasiswa_id')
            ->where('m_mahasiswa.mahasiswa_id', $id)
            ->first();

        return response()->json($data);
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
}
