<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'checkIfLoggedIn'])->group(function () {
    Route::get('/', function () {
        return 'Welcome to the API';
    });

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/protected', [AuthController::class, 'protectedRoute']);
});
