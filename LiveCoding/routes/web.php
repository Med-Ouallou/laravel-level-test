<?php

use App\Http\Controllers\ScoreController;
use Illuminate\Support\Facades\Route;

Route::resource('scores', ScoreController::class)->only(['index', 'store', 'destroy']);

// Pour que / redirige vers la liste
Route::get('/', [ScoreController::class, 'index']);