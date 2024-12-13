<?php

// use App\Http\Controllers\TugasController;

use App\Http\Controllers\api\TugasController;
use App\Http\Controllers\MahasiswaKompenControllerMbl;
use App\Http\Controllers\TugasController as ControllersTugasController;
use App\Http\Controllers\TugasControllerMbl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('all_data', [TugasControllerMbl::class, 'index']);
Route::post('input_data', [TugasControllerMbl::class, 'store']);
    
Route::post('list_mhs_kompen', [MahasiswaKompenControllerMbl::class, 'index']);
Route::post('show_list', [MahasiswaKompenControllerMbl::class, 'show']);