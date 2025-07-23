<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\IngredientController;

Route::get('/recipes', [RecipeController::class, 'index']);
Route::post('/recipes', [RecipeController::class, 'store']);
Route::get('/recipes/{id}', [RecipeController::class, 'show']);
Route::put('/recipes/{id}', [RecipeController::class, 'update']);
Route::delete('/recipes/{id}', [RecipeController::class, 'destroy']);
Route::get('/recipes/filter', [RecipeController::class, 'filter']);

Route::get('/ingredients', [IngredientController::class, 'index']);
Route::post('/ingredients', [IngredientController::class, 'store']);
Route::get('/ingredients/{id}', [IngredientController::class, 'show']);
Route::put('/ingredients/{id}', [IngredientController::class, 'update']);
Route::delete('/ingredients/{id}', [IngredientController::class, 'destroy']);
