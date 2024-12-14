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

Route::post('/login', App\Http\Controllers\api\LoginController::class)->name('login');
Route::post('/register', App\Http\Controllers\api\RegisterController::class)->name('register');
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

    Route::group(['prefix' => 'dosen'], function () {
        Route::post('dosen_data', [\App\Http\Controllers\api\DosenController::class, 'show']);
        Route::post('edit_profile', [\App\Http\Controllers\api\DosenController::class, 'edit'])->name('dosen.edit_profile');
        Route::post('edit_password', [\App\Http\Controllers\api\DosenController::class, 'update'])->name('dosen.edit_password');
    });

    Route::group(['prefix' => 'tendik'], function () {
        Route::post('tendik_data', [\App\Http\Controllers\api\TendikController::class, 'show']);
        Route::post('edit_profile', [\App\Http\Controllers\api\TendikController::class, 'edit'])->name('tendik.edit_profile');
        Route::post('edit_password', [\App\Http\Controllers\api\TendikController::class, 'update'])->name('tendik.edit_password');
    });
    
});