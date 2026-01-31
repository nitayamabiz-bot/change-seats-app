<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Settings\SeatLayoutController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect('/home') : app(AuthenticatedSessionController::class)->create();
});

Route::get('/home', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('home');

Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/settings', function (\Illuminate\Http\Request $request) {
    $seatLayout = \App\Models\SeatLayout::where('user_id', $request->user()->id)->first();

    return view('settings', ['seatLayout' => $seatLayout]);
})->middleware(['auth', 'verified'])->name('settings');

Route::post('/settings/seat-layout', [SeatLayoutController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('settings.seat-layout.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
