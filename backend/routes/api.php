<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MentorController;
use Illuminate\Support\Facades\Route;

// sleep(2); // simulates 1sec delay for local development

sleep(env('DELAY_TIME', 0));

Route::post('/login', [AuthController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/mentors', MentorController::class);
    Route::delete('/logout', [AuthController::class, 'destroy']);
});
