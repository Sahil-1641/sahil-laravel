<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/services', 'services')->name('services');
Route::view('/contact', 'contact')->name('contact');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('throttle:login');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::resource('projects', ProjectController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('auth');
Route::resource('projects', ProjectController::class)->only(['index', 'show']);

Route::resource('students', StudentController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('auth');
Route::resource('students', StudentController::class)->only(['index', 'show']);

Route::resource('attendances', AttendanceController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('auth');
Route::resource('attendances', AttendanceController::class)->only(['index', 'show']);

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
