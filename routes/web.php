<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::get('chirps/{id}', [ChirpController::class, 'show'])->name('chirps.show');
Route::post('chirps/comment/{id}', [ChirpController::class, 'comment'])->name('chirps.comment');
Route::post('chirps/like/{id}', [ChirpController::class, 'like'])->name('chirps.like');
Route::post('chirps/dislike/{id}', [ChirpController::class, 'dislike'])->name('chirps.dislike');
Route::get('search/', [ChirpController::class, 'search'])->name('chirps.search');

Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::post('/users/follow/{id}', [UserController::class, 'follow'])->name('users.follow');
Route::post('/users/unfollow/{id}', [UserController::class, 'unfollow'])->name('users.unfollow');

require __DIR__.'/auth.php';
