<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\ResponPengaduanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return redirect('/login');
});


Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth.session')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/trash', [PengaduanController::class, 'trash'])->name('pengaduan.trash');
    Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
    Route::get('/pengaduan/join', [PengaduanController::class, 'join'])->name('pengaduan.join');
    Route::delete('/pengaduan/{id}', [PengaduanController::class, 'destroy'])->name('pengaduan.destroy');
    Route::delete('/pengaduan/{id}/force', [PengaduanController::class, 'forceDelete'])->name('pengaduan.forceDelete');
    Route::get('/pengaduan/{id}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::get('/pengaduan/{id}/edit', [PengaduanController::class, 'edit'])->name('pengaduan.edit');
    Route::put('/pengaduan/{id}', [PengaduanController::class, 'update'])->name('pengaduan.update');
    Route::put('/pengaduan/{id}/restore', [PengaduanController::class, 'restore'])->name('pengaduan.restore');
    

    Route::post('/pengaduan/{pengaduan_id}/respon', [ResponPengaduanController::class, 'store'])->name('pengaduan.respon');
    Route::resource('kategori', KategoriController::class)->only(['index', 'create', 'store']);

    Route::middleware('admin')->group(function () {

    });
    
});

