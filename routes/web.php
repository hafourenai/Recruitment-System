<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/syarat', function () {
    return view('syarat');
}); // Need to create this

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('ratelimit.login:5,1');
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('ratelimit.login:3,1');
    
    // Password Reset Routes
    Route::get('/forgot-password', [AuthController::class, 'forgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email')->middleware('ratelimit.login:3,5');
    Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::post('/admin/pendaftar/{id}/status', [DashboardController::class, 'updateStatus'])->name('admin.updateStatus');
    Route::get('/admin/file/{id}', [DashboardController::class, 'viewFile'])->name('admin.file');
});

Route::middleware(['auth', 'role:dosen'])->group(function () {
    Route::get('/dosen/dashboard', [DashboardController::class, 'dosenDashboard'])->name('dosen.dashboard');
    Route::get('/dosen/file/{id}', [DashboardController::class, 'viewFile'])->name('dosen.file');
});

// Pendaftar Routes
Route::middleware(['auth', 'role:pendaftar'])->group(function () {
    Route::get('/pendaftar/dashboard', [DashboardController::class, 'pendaftarDashboard'])->name('pendaftar.dashboard');
    Route::get('/pendaftar/pengumpulan-berkas', [DashboardController::class, 'pendaftarBerkas'])->name('pendaftar.berkas_page');
    Route::get('/pendaftar/file/{id}', [DashboardController::class, 'viewFile'])->name('pendaftar.file');
    Route::post('/pendaftar/update-berkas', [DashboardController::class, 'updateBerkas'])->name('pendaftar.updateBerkas');
    // Also need delete route? Mockup shows "Hapus"
    Route::post('/pendaftar/delete-file/{type}', [DashboardController::class, 'deleteFile'])->name('pendaftar.deleteFile');
});

