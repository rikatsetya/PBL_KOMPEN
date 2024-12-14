<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\JenisModel;
use App\Models\PeriodeModel;
use App\Models\TugasModel;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function index(Request $request){
        $jenis = JenisModel::all();
        $periode = PeriodeModel::all();
        return response()->json([$jenis, $periode]);
    }

    public function create(Request $request){
        
        TugasModel::create($request->all());
        return "Berhasil Menyimpan Data!";
    }
}
