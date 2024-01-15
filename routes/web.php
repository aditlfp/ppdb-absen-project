<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('auth.login');
});


Route::view('data-people', 'person.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function() {
    Route::view('user', 'Admin.User.index');
    Route::view('siswa', 'Admin.Siswa.index');
    Route::view('jurusan', 'Admin.Jurusan.index');
    Route::view('absen', 'Admin.Absen.index');
    Route::view('admin-panel', 'Admin.index-admin');
});

Route::middleware(['auth', 'teach'])->prefix('teacher')->group(function() {
    Route::view('siswa-new', 'Teach.Siswa.index');
    Route::view('absensi-siswa', 'Teach.Absen.index');
});

Route::middleware(['auth'])->prefix('siswa')->group(function() {
    Route::view('data-absensi', 'Siswa.DataAbsen.index');
});

require __DIR__.'/auth.php';
