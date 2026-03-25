<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RecipeController;

Route::get('/ingredients', [IngredientController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::post('/api/recipes', [RecipeController::class, 'store']);
});
