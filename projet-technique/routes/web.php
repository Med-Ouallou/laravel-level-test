<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeamController;

// Public
Route::get('/players', [PublicController::class, 'players'])->name('public.players');
Route::get('/players/{player}', [PublicController::class, 'player'])->name('public.player');

// Admin
Route::prefix('admin')->group(function () {
    Route::get('/players', [AdminController::class, 'indexPlayers'])->name('admin.players');
    Route::get('/players/create', [AdminController::class, 'createPlayer']);
    Route::post('/players', [AdminController::class, 'storePlayer']);
    Route::get('/players/{player}/edit', [AdminController::class, 'editPlayer']);
    Route::put('/players/{player}', [AdminController::class, 'updatePlayer']);
    Route::delete('/players/{player}', [AdminController::class, 'deletePlayer']);

    // Teams
    Route::resource('teams', TeamController::class, ['names' => 'admin.teams']);
});