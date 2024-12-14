<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\api\MahasiswaController;
use App\Http\Controllers\api\PengumpulanController;
use App\Http\Controllers\api\UpdateKompenSelesaiAController;
use App\Http\Controllers\api\UpdateKompenSelesaiMController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;

/*
|---------------------------------------------------------------------------
| API Routes
|---------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/logout', App\Http\Controllers\Api\LoginController::class)->name('logout');
Route::middleware('auth:api')->group(function () {
    
    Route::post('all_data', [App\Http\Controllers\api\AbsensiController::class, 'index']);
    Route::post('show_data', [App\Http\Controllers\api\AbsensiController::class, 'show']);
    
    Route::group(['prefix' => 'mahasiswa'], function () {
        Route::post('/mahasiswa_data', [\App\Http\Controllers\api\MahasiswaController::class, 'show']);
        Route::post('/edit_profile', [\App\Http\Controllers\api\MahasiswaController::class, 'edit']);
        Route::post('/edit_password', [\App\Http\Controllers\api\MahasiswaController::class, 'update']);
    });
});

Route::get('all_data', [UpdateKompenSelesaiAController::class, 'showAllData']);
Route::post('show_data', [UpdateKompenSelesaiAController::class, 'showTaskDetail']);
Route::post('update_status', [UpdateKompenSelesaiAController::class, 'updateStatusAndReason']);

Route::post('all_data_m', [UpdateKompenSelesaiMController::class, 'showAllData']);
Route::post('show_data_m', [UpdateKompenSelesaiMController::class, 'showTaskDetail']);
