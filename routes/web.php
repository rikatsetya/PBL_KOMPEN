<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\MahasiswaController;
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

    // Route::middleware(['authorize:ADM'])->group(function () {
    //     Route::get('/level', [LevelController::class, 'index']);
    //     Route::post('/level/list', [LevelController::class, 'list']);
    //     Route::get('/level/create_ajax', [LevelController::class, 'create_ajax']);
    //     Route::post('/level/ajax', [LevelController::class, 'store_ajax']);
    //     Route::get('/level/import', [LevelController::class, 'import']);
    //     Route::post('/level/import_ajax', [LevelController::class, 'import_ajax']);
    //     Route::get('/level/export_excel', [LevelController::class, 'export_excel']);
    //     Route::get('/level/export_pdf', [LevelController::class, 'export_pdf']);
    //     Route::get('/level/{id}', [LevelController::class, 'show']);
    //     Route::get('/level/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
    //     Route::put('/level/{id}/update_ajax', [LevelController::class, 'update_ajax']);
    //     Route::get('/level/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
    //     Route::delete('/level/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
    // });

    // Route::middleware(['authorize:ADM'])->group(function () {
    //     Route::get('/user', [UserController::class, 'index']);
    //     Route::post('/user/list', [UserController::class, 'list']);
    //     Route::get('/user/create_ajax', [UserController::class, 'create_ajax']);
    //     Route::post('/user/ajax', [UserController::class, 'store_ajax']);
    //     Route::get('/user/import', [UserController::class, 'import']);
    //     Route::post('/user/import_ajax', [UserController::class, 'import_ajax']);
    //     Route::get('/user/export_excel', [UserController::class, 'export_excel']);
    //     Route::get('/user/export_pdf', [UserController::class, 'export_pdf']);
    //     Route::get('/user/{id}', [UserController::class, 'show']);
    //     Route::get('/user/{id}/edit_ajax', [UserController::class, 'edit_ajax']);
    //     Route::put('/user/{id}/update_ajax', [UserController::class, 'update_ajax']);
    //     Route::get('/user/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
    //     Route::delete('/user/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
    // });

    // Route::middleware(['authorize:ADM'])->group(function () {
    //     Route::get('/kompetensi', [UserController::class, 'index']);
    //     Route::post('/kompetensi/list', [UserController::class, 'list']);
    //     Route::get('/kompetensi/create_ajax', [UserController::class, 'create_ajax']);
    //     Route::post('/kompetensi/ajax', [UserController::class, 'store_ajax']);
    //     Route::get('/kompetensi/import', [UserController::class, 'import']);
    //     Route::post('/kompetensi/import_ajax', [UserController::class, 'import_ajax']);
    //     Route::get('/kompetensi/export_excel', [UserController::class, 'export_excel']);
    //     Route::get('/kompetensi/export_pdf', [UserController::class, 'export_pdf']);
    //     Route::get('/kompetensi/{id}', [UserController::class, 'show']);
    //     Route::get('/kompetensi/{id}/edit_ajax', [UserController::class, 'edit_ajax']);
    //     Route::put('/kompetensi/{id}/update_ajax', [UserController::class, 'update_ajax']);
    //     Route::get('/kompetensi/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
    //     Route::delete('/kompetensi/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
    // });

    // Route::middleware(['authorize:ADM'])->group(function () {
    //     Route::get('/mahasiswa', [MahasiswaController::class, 'index']);
    //     Route::post('/mahasiswa/list', [MahasiswaController::class, 'list']);
    //     Route::get('/mahasiswa/create_ajax', [MahasiswaController::class, 'create_ajax']);
    //     Route::post('/mahasiswa/ajax', [MahasiswaController::class, 'store_ajax']);
    //     Route::get('/mahasiswa/import', [MahasiswaController::class, 'import']);
    //     Route::post('/mahasiswa/import_ajax', [MahasiswaController::class, 'import_ajax']);
    //     Route::get('/mahasiswa/export_excel', [MahasiswaController::class, 'export_excel']);
    //     Route::get('/mahasiswa/export_pdf', [MahasiswaController::class, 'export_pdf']);
    //     Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'show']);
    //     Route::get('/mahasiswa/{id}/edit_ajax', [MahasiswaController::class, 'edit_ajax']);
    //     Route::put('/mahasiswa/{id}/update_ajax', [MahasiswaController::class, 'update_ajax']);
    //     Route::get('/mahasiswa/{id}/delete_ajax', [MahasiswaController::class, 'confirm_ajax']);
    //     Route::delete('/mahasiswa/{id}/delete_ajax', [MahasiswaController::class, 'delete_ajax']);
    // });
});