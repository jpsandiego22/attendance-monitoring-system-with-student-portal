<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\QrController;
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
Route::redirect('/', 'home');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/redirectto', [LoginController::class, 'redirectto'])->name('redirectto');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/registration', [RegisterController::class, 'register'])->name('login.register');
Route::post('/registration', [RegisterController::class, 'registerUser'])->name('registration.registerUser');
Route::post('/registration/search', [RegisterController::class, 'search_identification'])->name('registration.search');




Route::middleware(['auth', 'role:0,1'])->group(function () {
    Route::get('/admin/home', [HomeController::class, 'index'])->name('admin.home');
    Route::get('/admin/users/registration', [UsersController::class, 'register'])->name('user.register');
    Route::post('/admin/users/registration', [UsersController::class, 'user_create'])->name('user.create');
    Route::get('/admin/users/list-show', [UsersController::class, 'list'])->name('user.listview');
    Route::post('/admin/users/list-update/{id}', [UsersController::class, 'user_update'])->name('user.userUpdate');
    Route::get('/admin/qr', [QrController::class, 'index'])->name('admin.qr');
});

Route::middleware(['auth', 'role:2'])->group(function () {
   Route::get('/student/portal', [HomeController::class, 'studentindex'])->name('student.home');
});
Route::middleware(['auth', 'role:0,1,2'])->group(function () {
   Route::post('/upload/photo', [MasterController::class, 'upload_photo'])->name('upload.photo');
});




