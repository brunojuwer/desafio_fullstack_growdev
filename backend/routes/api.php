<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MentorController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/mentors', MentorController::class);
    Route::delete('/logout', [AuthController::class, 'destroy']);
});
