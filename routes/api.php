<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

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



Route::middleware(['auth', 'teach'])->prefix('teacher')->group(function() {
    Route::apiResource('/ppdb-siswa', SiswaController::class);
    Route::apiResource('/absensi', AbsenController::class);
});

Route::middleware(['auth'])->prefix('siswa')->group(function() {
    Route::apiResource('/data-absen', AbsenController::class)->only(['index', 'show']);
});

