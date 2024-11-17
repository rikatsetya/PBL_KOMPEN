<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\MahasiswaKompenController;

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

Route::get('/mhs', [MahasiswaKompenController::class, 'index']);
Route::post('/mhs/list', [MahasiswaKompenController::class, 'list']);
Route::get('/mhs/{id}', [MahasiswaKompenController::class, 'show']);
Route::get('/mhs/create_ajax', [MahasiswaKompenController::class, 'create_ajax']);
Route::post('/mhs/ajax', [MahasiswaKompenController::class, 'store_ajax']);
Route::get('/mhs/{id}/edit_ajax', [MahasiswaKompenController::class, 'edit_ajax']);
Route::put('/mhs/{id}/update_ajax', [MahasiswaKompenController::class, 'update_ajax']);
Route::get('/mhs/{id}/delete_ajax', [MahasiswaKompenController::class, 'confirm_ajax']);
Route::delete('/mhs/{id}/delete_ajax', [MahasiswaKompenController::class, 'delete_ajax']); 
