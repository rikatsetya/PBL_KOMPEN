<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\KompetensiController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

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

Route::pattern('id', '[0-9]+');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('register', [AuthController::class, 'register']);
Route::post('register', [AuthController::class, 'store']);

Route::middleware(['auth'])->group(function () {
    
    Route::get('/', [WelcomeController::class, 'index']);

    Route::middleware(['authorize:ADM'])->group(function () {
        Route::get('/level', [LevelController::class, 'index']);
        Route::post('/level/list', [LevelController::class, 'list']);
        Route::get('/level/create_ajax', [LevelController::class, 'create_ajax']);
        Route::post('/level/ajax', [LevelController::class, 'store_ajax']);
        Route::get('/level/import', [LevelController::class, 'import']);
        Route::post('/level/import_ajax', [LevelController::class, 'import_ajax']);
        Route::get('/level/export_excel', [LevelController::class, 'export_excel']);
        Route::get('/level/export_pdf', [LevelController::class, 'export_pdf']);
        Route::get('/level/{id}', [LevelController::class, 'show']);
        Route::get('/level/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
        Route::put('/level/{id}/update_ajax', [LevelController::class, 'update_ajax']);
        Route::get('/level/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
        Route::delete('/level/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
    });

    Route::middleware(['authorize:ADM'])->group(function () {
        Route::get('/user', [UserController::class, 'index']);
        Route::post('/user/list', [UserController::class, 'list']);
        Route::get('/user/create_ajax', [UserController::class, 'create_ajax']);
        Route::post('/user/ajax', [UserController::class, 'store_ajax']);
        Route::get('/user/import', [UserController::class, 'import']);
        Route::post('/user/import_ajax', [UserController::class, 'import_ajax']);
        Route::get('/user/export_excel', [UserController::class, 'export_excel']);
        Route::get('/user/export_pdf', [UserController::class, 'export_pdf']);
        Route::get('/user/{id}', [UserController::class, 'show']);
        Route::get('/user/{id}/edit_ajax', [UserController::class, 'edit_ajax']);
        Route::put('/user/{id}/update_ajax', [UserController::class, 'update_ajax']);
        Route::get('/user/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
        Route::delete('/user/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
    });

    Route::middleware(['authorize:ADM'])->group(function () {
        Route::get('/kompetensi', [KompetensiController::class, 'index']);
        Route::post('/kompetensi/list', [KompetensiController::class, 'list']);
        Route::get('/kompetensi/create_ajax', [KompetensiController::class, 'create_ajax']);
        Route::post('/kompetensi/ajax', [KompetensiController::class, 'store_ajax']);
        Route::get('/kompetensi/import', [KompetensiController::class, 'import']);
        Route::post('/kompetensi/import_ajax', [KompetensiController::class, 'import_ajax']);
        Route::get('/kompetensi/export_excel', [KompetensiController::class, 'export_excel']);
        Route::get('/kompetensi/export_pdf', [KompetensiController::class, 'export_pdf']);
        Route::get('/kompetensi/{id}', [KompetensiController::class, 'show']);
        Route::get('/kompetensi/{id}/edit_ajax', [KompetensiController::class, 'edit_ajax']);
        Route::put('/kompetensi/{id}/update_ajax', [KompetensiController::class, 'update_ajax']);
        Route::get('/kompetensi/{id}/delete_ajax', [KompetensiController::class, 'confirm_ajax']);
        Route::delete('/kompetensi/{id}/delete_ajax', [KompetensiController::class, 'delete_ajax']);
    });

    Route::middleware(['authorize:ADM'])->group(function () {
        Route::get('/jenis', [JenisController::class, 'index']);
        Route::post('/jenis/list', [JenisController::class, 'list']);
        Route::get('/jenis/create_ajax', [JenisController::class, 'create_ajax']);
        Route::post('/jenis/ajax', [JenisController::class, 'store_ajax']);
        Route::get('/jenis/import', [JenisController::class, 'import']);
        Route::post('/jenis/import_ajax', [JenisController::class, 'import_ajax']);
        Route::get('/jenis/export_excel', [JenisController::class, 'export_excel']);
        Route::get('/jenis/export_pdf', [JenisController::class, 'export_pdf']);
        Route::get('/jenis/{id}', [JenisController::class, 'show']);
        Route::get('/jenis/{id}/edit_ajax', [JenisController::class, 'edit_ajax']);
        Route::put('/jenis/{id}/update_ajax', [JenisController::class, 'update_ajax']);
        Route::get('/jenis/{id}/delete_ajax', [JenisController::class, 'confirm_ajax']);
        Route::delete('/jenis/{id}/delete_ajax', [JenisController::class, 'delete_ajax']);
    });

    Route::middleware(['authorize:ADM'])->group(function () {
        Route::get('/daftar_tugas', [TugasController::class, 'index']);
        Route::post('/daftar_tugas/list', [TugasController::class, 'list']);
        Route::get('/daftar_tugas/create_ajax', [TugasController::class, 'create_ajax']);
        Route::post('/daftar_tugas/ajax', [TugasController::class, 'store_ajax']);
        Route::get('/daftar_tugas/import', [TugasController::class, 'import']);
        Route::post('/daftar_tugas/import_ajax', [TugasController::class, 'import_ajax']);
        Route::get('/daftar_tugas/export_excel', [TugasController::class, 'export_excel']);
        Route::get('/daftar_tugas/export_pdf', [TugasController::class, 'export_pdf']);
        Route::get('/daftar_tugas/{id}', [TugasController::class, 'show']);
        Route::get('/daftar_tugas/{id}/edit_ajax', [TugasController::class, 'edit_ajax']);
        Route::put('/daftar_tugas/{id}/update_ajax', [TugasController::class, 'update_ajax']);
        Route::get('/daftar_tugas/{id}/delete_ajax', [TugasController::class, 'confirm_ajax']);
        Route::delete('/daftar_tugas/{id}/delete_ajax', [TugasController::class, 'delete_ajax']);
    });

    Route::middleware(['authorize:ADM'])->group(function () {
        Route::get('/mahasiswa', [MahasiswaController::class, 'index']);
        Route::post('/mahasiswa/list', [MahasiswaController::class, 'list']);
        Route::get('/mahasiswa/create_ajax', [MahasiswaController::class, 'create_ajax']);
        Route::post('/mahasiswa/ajax', [MahasiswaController::class, 'store_ajax']);
        Route::get('/mahasiswa/import', [MahasiswaController::class, 'import']);
        Route::post('/mahasiswa/import_ajax', [MahasiswaController::class, 'import_ajax']);
        Route::get('/mahasiswa/export_excel', [MahasiswaController::class, 'export_excel']);
        Route::get('/mahasiswa/export_pdf', [MahasiswaController::class, 'export_pdf']);
        Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'show']);
        Route::get('/mahasiswa/{id}/edit_ajax', [MahasiswaController::class, 'edit_ajax']);
        Route::put('/mahasiswa/{id}/update_ajax', [MahasiswaController::class, 'update_ajax']);
        Route::get('/mahasiswa/{id}/delete_ajax', [MahasiswaController::class, 'confirm_ajax']);
        Route::delete('/mahasiswa/{id}/delete_ajax', [MahasiswaController::class, 'delete_ajax']);
    });
});