<?php

use App\Http\Controllers\Api\CustomFrameController;
use App\Http\Controllers\Api\LayoutController;
use App\Http\Controllers\FrameController;
use App\Http\Controllers\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — Cekrek.in
|--------------------------------------------------------------------------
*/

// ── Health check / current user ─────────────────────────────────────────
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ── C. Layouts (Fitur Layout) ───────────────────────────────────────────
// Public: baca layout untuk pilihan di editor
Route::get('layouts', [LayoutController::class, 'index']);
Route::get('layouts/{layout}', [LayoutController::class, 'show']);

// Admin only: kelola layout
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('layouts', [LayoutController::class, 'store']);
    Route::put('layouts/{layout}', [LayoutController::class, 'update']);
    Route::delete('layouts/{layout}', [LayoutController::class, 'destroy']);
});

// ── H. Custom Frames (Fitur Frame Custom) ───────────────────────────────
// Semua endpoint custom frame butuh autentikasi.
// Kepemilikan diperiksa di dalam controller berdasarkan user_id.
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('custom-frames', CustomFrameController::class);
});

// ── Frames & Events (Fitur Teman Kelompok) ───────────────────────────────
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
