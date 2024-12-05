<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaKompenController;
use App\Http\Controllers\CetakSuratController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/mahasiswa', [MahasiswaKompenController::class, 'index']);
Route::post('/mahasiswa/list', [MahasiswaKompenController::class, 'list']);
Route::get('/mahasiswa/{id}', [MahasiswaKompenController::class, 'show']);
Route::get('/mahasiswa/export_excel', [MahasiswaKompenController::class, 'export_excel']);
Route::get('/mahasiswa/export_pdf', [MahasiswaKompenController::class, 'export_pdf']);

Route::get('/cetak', [CetakSuratController::class, 'index']);
Route::post('/cetak/list', [CetakSuratController::class, 'list']);
Route::get('/cetak/export_pdf/{id}', [CetakSuratController::class, 'exportPdf']);  // Perubahan di sini

