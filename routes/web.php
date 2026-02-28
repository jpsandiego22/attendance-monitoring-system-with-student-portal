<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\QrScannerController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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
Route::redirect('/', 'login');

Route::get('/error', function () {
   return view('error');
})->name('error');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/redirectto', [LoginController::class, 'redirectto'])->name('redirectto');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// GoogleCloudAuth
Route::get('login/ams-google', [GoogleAuthController::class, 'redirectToGoogle'])->name('login.google.redirect');
Route::get('/login/ams-google/callback', [GoogleAuthController::class, 'auth_login'])->name('google.auth.login');


Route::get('/registration', [RegisterController::class, 'register'])->name('login.register');
Route::post('/registration', [RegisterController::class, 'registerUser'])->name('registration.registerUser');
Route::post('/registration/search', [RegisterController::class, 'search_identification'])->name('registration.search');


// ONLY ADMIN ROLE HAS ACCESS
Route::middleware(['auth', 'role:0'])->group(function () {
Route::get('/qr/scanner', [QrScannerController::class, 'index'])->name('qr.scanner');
Route::post('/qr/scan', [QrScannerController::class, 'scan_qr'])->name('qr.scan');
});

// ONLY ADMIN / FACULTY ROLE HAS ACCESS
Route::middleware(['auth', 'role:0,1'])->group(function () {
    Route::get('/admin/home', [HomeController::class, 'index'])->name('admin.home');
    Route::get('/admin/users/registration', [UsersController::class, 'register'])->name('user.register');
    Route::post('/admin/users/registration', [UsersController::class, 'user_create'])->name('user.create');
    Route::get('/admin/users/list-show', [UsersController::class, 'list'])->name('user.listview');
    Route::post('/admin/users/list-update/{id}', [UsersController::class, 'user_update'])->name('user.userUpdate');
    Route::get('/admin/qr', [QrController::class, 'index'])->name('admin.qr');
});

// ONLY STUDENT ROLE HAS ACCESS
Route::middleware(['auth', 'role:2'])->group(function () {
   Route::get('/student/portal', [HomeController::class, 'studentindex'])->name('student.home');
});

// ALL USER ROLE HAS ACCESS
Route::middleware(['auth', 'role:0,1,2'])->group(function () {
   Route::post('/upload/photo', [MasterController::class, 'upload_photo'])->name('upload.photo');
   Route::post('/change/password', [MasterController::class, 'change_password'])->name('change.password');
});




