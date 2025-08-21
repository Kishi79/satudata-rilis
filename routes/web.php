<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SchedulePublicController;


Route::get('/', fn() => redirect()->route('jadwal.public'));

Route::get('/jadwal-rilis', [SchedulePublicController::class, 'index'])
  ->name('jadwal.public');

Route::get('/dashboard', function () {
  // misalnya langsung redirect ke jadwal publik
  return redirect()->route('jadwal.public');
})->middleware(['auth'])->name('dashboard');


// area login untuk CRUD
Route::middleware(['auth','role:Admin'])->group(function () {
    Route::resource('admin/jadwal', ScheduleController::class)
         ->parameters(['jadwal'=>'schedule'])
         ->except(['show']);
});


// khusus hapus hanya admin
Route::delete('admin/jadwal/{schedule}', [ScheduleController::class, 'destroy'])
  ->middleware(['auth', 'role:Admin'])
  ->name('jadwal.destroy');

require __DIR__ . '/auth.php';
