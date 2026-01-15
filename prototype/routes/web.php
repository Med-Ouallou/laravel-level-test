<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeamController;

// Redirect root to admin players
Route::get('/', function () {
    return redirect()->route('admin.players');
});

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fr'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

// Admin
Route::prefix('admin')->group(function () {
    Route::get('/players', [AdminController::class, 'indexPlayers'])->name('admin.players');
    Route::get('/players/create', [AdminController::class, 'createPlayer']);
    Route::post('/players', [AdminController::class, 'storePlayer']);

    // Teams
    Route::resource('teams', TeamController::class, ['names' => 'admin.teams', 'only' => ['index', 'create', 'store']]);
});