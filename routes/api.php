
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrameController;
use App\Http\Controllers\EventController;

// Endpoint publik: menampilkan frame
Route::get('/frames', [FrameController::class, 'index']);
Route::get('/frames/{id}', [FrameController::class, 'show']);

// Endpoint pengelolaan frame
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/frames', [FrameController::class, 'store']);
    Route::put('/frames/{id}', [FrameController::class, 'update']);
    Route::patch('/frames/{id}', [FrameController::class, 'update']);
    Route::delete('/frames/{id}', [FrameController::class, 'destroy']);
});

// Endpoint publik: menampilkan event
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{id}', [EventController::class, 'show']);

// Endpoint pengelolaan event
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/events', [EventController::class, 'store']);
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::patch('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);
});
