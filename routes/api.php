<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::apiResource('books', BookController::class)->only(['index', 'show']);
Route::apiResource('genres', GenreController::class)->only(['index', 'show']);
Route::apiResource('authors', AuthorController::class)->only(['index', 'show']);


Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('books', BookController::class)->except(['index', 'show']);
    Route::apiResource('genres', GenreController::class)->except(['index', 'show']);
    Route::apiResource('authors', AuthorController::class)->except(['index', 'show']);

    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'customer'])
    ->controller(TransactionController::class)
    ->prefix('transactions')
    ->group(function () {
        Route::post('/', 'store');
        Route::get('/{transaction}', 'show');
        Route::match(['put', 'patch'], '/{transaction}', 'update');
    });
