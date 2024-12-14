<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\api\UserController;
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
// Route::post('all_data', [\App\Http\Controllers\api\KompenSelesaiAController::class, 'showAllData']);
// Route::post('detail_kompen_selesai', [\App\Http\Controllers\api\KompenSelesaiAController::class, 'showTaskDetail']);
// Route::post('update_kompen_selesai', [\App\Http\Controllers\api\KompenSelesaiAController::class, 'updateStatusAndReason']);


Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/logout', App\Http\Controllers\Api\LoginController::class)->name('logout');
Route::middleware('auth:api')->group(function () {
    
    Route::group(['prefix' => 'alpha'], function () {
        Route::post('all_data', [App\Http\Controllers\api\AbsensiController::class, 'index']);
        Route::post('show_data', [App\Http\Controllers\api\AbsensiController::class, 'show']);
    });
    
    Route::group(['prefix' => 'kompen'], function () {
        Route::post('list_mhs_kompen', [App\Http\Controllers\api\MahasiswaKompenController::class, 'index']);
        Route::post('show_list', [App\Http\Controllers\api\MahasiswaKompenController::class, 'show']);
    });
    
    Route::group(['prefix' => 'mahasiswa'], function () {
        Route::post('mahasiswa_data', [\App\Http\Controllers\api\MahasiswaController::class, 'show']);
        Route::post('edit_profile', [\App\Http\Controllers\api\MahasiswaController::class, 'edit']);
        Route::post('edit_password', [\App\Http\Controllers\api\MahasiswaController::class, 'update']);
        Route::post('show_kompen_selesai', [\App\Http\Controllers\api\KompenSelesaiMhsController::class, 'showAllData']);
    });
    
    Route::group(['prefix' => 'dosen'], function () {
        Route::post('dosen_data', [\App\Http\Controllers\api\DosenController::class, 'show']);
        Route::post('edit_profile', [\App\Http\Controllers\api\DosenController::class, 'edit']);
        Route::post('edit_password', [\App\Http\Controllers\api\DosenController::class, 'update']);
        Route::post('show_kompen_selesai', [\App\Http\Controllers\api\KompenSelesaiAController::class, 'showAllData']);
        Route::post('detail_kompen_selesai', [\App\Http\Controllers\api\KompenSelesaiAController::class, 'showTaskDetail']);
        Route::post('update_kompen_selesai', [\App\Http\Controllers\api\KompenSelesaiAController::class, 'updateStatusAndReason']);
    });

    Route::group(['prefix' => 'tendik'], function () {
        Route::post('tendik_data', [\App\Http\Controllers\api\TendikController::class, 'show']);
        Route::post('edit_profile', [\App\Http\Controllers\api\TendikController::class, 'edit']);
        Route::post('edit_password', [\App\Http\Controllers\api\TendikController::class, 'update']);
        Route::post('show_kompen_selesai', [\App\Http\Controllers\api\KompenSelesaiAController::class, 'showAllData']);
        Route::post('detail_kompen_selesai', [\App\Http\Controllers\api\KompenSelesaiAController::class, 'showTaskDetail']);
        Route::post('update_kompen_selesai', [\App\Http\Controllers\api\KompenSelesaiAController::class, 'updateStatusAndReason']);
    });
});