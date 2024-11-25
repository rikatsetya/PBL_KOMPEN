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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('all_data',[App\Http\Controllers\api\AbsensiController::class, 'index']);
Route::post('show_data',[App\Http\Controllers\api\AbsensiController::class, 'show']);
Route::post('user_data/{id}',[\App\Http\Controllers\api\MahasiswaController::class, 'show']);
Route::post('edit_data',[\App\Http\Controllers\api\MahasiswaController::class, 'edit']);
Route::post('edit_pass',[\App\Http\Controllers\api\MahasiswaController::class, 'update']);