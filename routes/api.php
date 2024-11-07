<?php

use App\Http\Controllers\PengumpulanController;
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

Route::post("all_data", [PengumpulanController::class, "index"]);       
Route::post("create_data", [PengumpulanController::class, "store"]);    
Route::post("show_data", [PengumpulanController::class, "show"]);    
Route::post("edit_data", [PengumpulanController::class, "edit"]);   
Route::post("delete_data", [PengumpulanController::class, "destroy"]);
