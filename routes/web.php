<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SchedulePublicController;

Route::get('/dashboard', function () {
    return redirect()->route('jadwal.public');
})->middleware(['auth'])->name('dashboard');


Route::get('/', fn() => redirect()->route('jadwal.public'));

Route::get('/jadwal-rilis', [SchedulePublicController::class,'index'])->name('jadwal.public');

// area login
Route::middleware(['auth'])->group(function(){
  Route::resource('admin/jadwal', ScheduleController::class)->parameters(['jadwal'=>'schedule'])
    ->except(['show']);
  // batasi delete hanya admin
  Route::delete('admin/jadwal/{schedule}', [ScheduleController::class,'destroy'])
       ->middleware('role:Admin')->name('jadwal.destroy');
});
require __DIR__.'/auth.php';
