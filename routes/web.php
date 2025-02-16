<?php

use App\Http\Controllers\PollController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('polls.index');
});

Route::get('polls/', [PollController::class, 'index'])->name('polls.index');

Route::middleware(['auth'])->group(function () {
    Route::prefix('polls')->name('polls.')->group(function () {
        Route::get('/create', [PollController::class, 'create'])->name('create');
        Route::get('/edit', [PollController::class, 'edit'])->name('edit');
        Route::post('/', [PollController::class, 'store'])->name('store');
        Route::get('/{poll}', [PollController::class, 'show'])->name('show');
        Route::put('/{poll}', [PollController::class, 'update'])->name('update');
        Route::delete('/{poll}', [PollController::class, 'destroy'])->name('destroy');
        Route::post('/{poll}/vote', [PollController::class, 'vote'])->name('vote');

        Route::get('/user-polls', [PollController::class, 'getUserPolls'])->name('user-polls');
    });
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
