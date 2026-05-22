<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Proposal routes
    Route::resource('proposal', ProposalController::class);
    Route::get('/proposal/{proposal}/generate', [ProposalController::class, 'generatePdf'])
        ->name('proposal.generate');

    // LPJ — Phase 3
    Route::get('/lpj/create', fn() => abort(503, 'Segera hadir — Phase 3'))->name('lpj.create');
    Route::get('/lpj', fn() => abort(503, 'Segera hadir — Phase 3'))->name('lpj.index');
});

require __DIR__.'/auth.php';
