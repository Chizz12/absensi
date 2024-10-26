<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/attendance', [App\Http\Controllers\HomeController::class, 'attendance'])->name('attendance');
Route::get('/shift', [App\Http\Controllers\HomeController::class, 'shift'])->name('shift');
Route::get('/add-attendance/{id}/{type}', [App\Http\Controllers\HomeController::class, 'addAttendance'])->name('add-attendance');
Route::post('/post-attendance', [App\Http\Controllers\HomeController::class, 'postAttendance'])->name('post-attendance');
Route::get('/leave', [App\Http\Controllers\HomeController::class, 'leave'])->name('leave');
Route::get('/add-leave', [App\Http\Controllers\HomeController::class, 'addLeave'])->name('add-leave');
Route::post('/post-leave', [App\Http\Controllers\HomeController::class, 'postLeave'])->name('post-leave');
Route::get('/permit', [App\Http\Controllers\HomeController::class, 'permit'])->name('permit');
Route::get('/add-permit', [App\Http\Controllers\HomeController::class, 'addPermit'])->name('add-permit');
Route::post('/post-permit', [App\Http\Controllers\HomeController::class, 'postPermit'])->name('post-permit');
