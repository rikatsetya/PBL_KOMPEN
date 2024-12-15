<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;

class MahasiswaKompenController extends Controller
{
    public function index()
    {
        $data = MahasiswaModel::select(
            'm_mahasiswa.mahasiswa_id',
            'nim',
            'mahasiswa_nama',
            't_absensi_mhs.poin',
            't_absensi_mhs.status',
        )
            ->leftJoin('t_absensi_mhs', 'm_mahasiswa.mahasiswa_id', '=', 't_absensi_mhs.mahasiswa_id')
            ->leftJoin('t_periode', 't_absensi_mhs.periode_id', '=', 't_periode.periode_id')
            ->where('t_absensi_mhs.alpha', '!=', '0')
            ->get();

        return response()->json([
            'success'   => true,
            'data'      => $data
        ]);
    }

    public function show(Request $request)
    {

        $id = $request->input('id');

        $data = MahasiswaModel::select(
            'm_mahasiswa.mahasiswa_id',
            'user_id',
            'nim',
            'mahasiswa_nama',
            't_absensi_mhs.alpha',
            't_absensi_mhs.poin',
            't_absensi_mhs.status',
        )
            ->leftJoin('t_absensi_mhs', 'm_mahasiswa.mahasiswa_id', '=', 't_absensi_mhs.mahasiswa_id')
            ->where('m_mahasiswa.user_id', $id)
            ->first();

        return response()->json([
            'success'   => true,
            'data'      => $data
        ]);
    }
}
