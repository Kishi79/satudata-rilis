<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SchedulePublicController;

// Redirect root ke jadwal publik
Route::get('/', fn() => redirect()->route('jadwal.public'));

//  Halaman publik (tanpa login)
Route::get('/jadwal-rilis', [SchedulePublicController::class, 'index'])
    ->name('jadwal.public');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


//  Area Admin (CRUD Jadwal)
Route::prefix('admin')->middleware(['auth','role:Admin'])->group(function () {
    Route::resource('jadwal', ScheduleController::class)
        ->names('admin.jadwal')
        ->parameters(['jadwal' => 'schedule']); 
});



//  Auth routes (login, register, dll dari Breeze/Fortify)
require __DIR__ . '/auth.php';
