<?php

use App\Http\Controllers\PilihKompenController;
use App\Http\Controllers\PilihKompenControllerController;
use App\Http\Controllers\TugasController;
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

Route::get('welcome', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'tugas'], function() {
    Route::get('/', [TugasController::class, 'index']);
    Route::post('/list', [TugasController::class, 'list']);
    Route::get('/create', [TugasController::class, 'create']);
    Route::get('/create_ajax', [TugasController::class, 'create_ajax']);
    Route::post('/', [TugasController::class, 'store']);
    Route::post('/ajax', [TugasController::class, 'store_ajax']);
    Route::get('/{id}', [TugasController::class, 'show']);
    Route::get('/{id}/edit', [TugasController::class, 'edit']);
    Route::put('/{id}', [TugasController::class, 'update']);
    Route::get('/import', [TugasController::class, 'import']); //ajax form upload excel
    Route::post('/import_ajax', [TugasController::class, 'import_ajax']); //ajax import excel
    Route::get('/export_excel', [TugasController::class, 'export_excel']); // export excel
    Route::get('/export_pdf', [TugasController::class, 'export_pdf']); // export pdf
    Route::get('/{id}/show_ajax', [TugasController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [TugasController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [TugasController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [TugasController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [TugasController::class, 'delete_ajax']);
    Route::delete('/{id}', [TugasController::class, 'destroy']);
});

Route::group(['prefix' => 'pilihkompen'], function() {
    Route::get('/', [PilihKompenController ::class, 'index']);
    Route::post('/list', [PilihKompenController::class, 'list']);
    Route::get('/{id}/show_ajax', [PilihKompenController::class, 'show_ajax']);
});