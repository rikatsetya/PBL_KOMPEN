<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\JenisModel;
use App\Models\PeriodeModel;
use App\Models\TugasModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TugasController extends Controller
{
    public function tugasJenisPeriode()
    {
        $jenis = JenisModel::all();
        $periode = PeriodeModel::all();
        return response()->json([
            'success' => true,
            'jenis' => $jenis,
            'periode' => $periode,
        ], 200);
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $request['user_id'] = $user->user_id;
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'periode_id' => 'required|integer',
            'jenis_id' => 'required|integer',
            'tugas_nama' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'tugas_bobot' => 'required|integer',
            'tugas_tenggat' => 'required|date',
            'kuota' => 'required|integer',
            
        ]);
        // cek apakah request berupa ajax
        if ($validator->fails()) {
            return response()->json([
                'success'    => false, // response status, false: error/gagal, true: berhasil
                'message'   => 'Validasi Gagal',
                'msgField'  => $validator->errors(), // pesan error validasi
            ]);
        }

        $data = TugasModel::create($request->all());
        if ($data) {
            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);
        }

        // return JSON process insert failed
        return response()->json([
            'success' => false,
        ], 409);
        
        return "Berhasil Menyimpan Data!";
    }

    public function showForDT()
    {
        $user = Auth::user();
        $data = TugasModel::with(['user', 'jenis', 'periode'])
            ->whereHas('user', function ($query) use ($user) {
                $query->where('user_id', $user->user_id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function showForMhs()
    {
        $data = TugasModel::with(['user', 'jenis', 'periode'])->get();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
