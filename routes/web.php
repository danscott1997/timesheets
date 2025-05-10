<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TimeEntriesController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', fn() => redirect()->route('timesheet.index'))->name('dashboard');

    Route::prefix('staff')->name('staff.')->group(function () {
        Route::get('/create', [StaffController::class, 'create'])->name('create');
        Route::post('/create', [StaffController::class, 'store'])->name('store');
    });

    Route::prefix('timesheet')->name('timesheet.')->group(function () {
        Route::get('/', [TimesheetController::class, 'index'])->name('index');
        Route::get('/upload', fn() => null)->name('upload');
    });

    Route::prefix('time-entries')->name('time-entries.')->group(function () {
        Route::get('/create', [TimeEntriesController::class, 'create'])->name('create');
        Route::post('/create', [TimeEntriesController::class, 'store'])->name('store');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';
