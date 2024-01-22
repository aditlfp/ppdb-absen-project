<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\View\SiswaController as ViewSiswaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\View\SiswaTeachController;
use App\Http\Controllers\View\JurusanController as ViewJurusanController;
use App\Http\Controllers\View\UserController as ViewUserController;
use App\Http\Controllers\View\AbsensiController as ViewAbsenController;
use Illuminate\Support\Facades\Route;

/*AbsensiController
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});


Route::view('data-people', 'person.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/menu', function () {
    return view('menu');
})->middleware(['auth', 'verified'])->name('menu');

// Route API

Route::middleware(['auth', 'admin'])->prefix('api/admin')->group(function() {
    Route::apiResource('/user', UserController::class);
    Route::apiResource('/jurusan', JurusanController::class);
    Route::apiResource('/siswa', SiswaController::class);
    Route::apiResource('/absen', AbsenController::class);
});


Route::middleware(['auth', 'teach'])->prefix('api/teacher')->group(function() {
    Route::apiResource('/ppdb-siswa', SiswaController::class);
    Route::apiResource('/absensi', AbsenController::class);
    Route::apiResource('/data-jurusan', JurusanController::class);

});


// End Route API

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route View Only

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function() {
    Route::resource('user-data', ViewUserController::class);
    Route::resource('siswa-data', ViewSiswaController::class);
    Route::resource('jurusan-data', ViewJurusanController::class);
    Route::resource('absen-data', ViewAbsenController::class);
    Route::view('admin-panel', 'Admin.index-admin')->name('admin-panel');
});

Route::middleware(['auth', 'teach'])->prefix('teacher')->group(function() {
    Route::resource('siswa-new', SiswaTeachController::class);
    Route::view('absensi-siswa', 'Teach.Absen.index');
});

// End Route

Route::middleware(['auth'])->prefix('siswa')->group(function() {
    Route::view('data-absensi', 'Siswa.DataAbsen.index');
});

require __DIR__.'/auth.php';
