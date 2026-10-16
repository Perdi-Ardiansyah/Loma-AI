<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Endpoint untuk AI (Di-handle oleh Controller)
use App\Http\Controllers\AIController;

Route::post('/process-ai', [AIController::class, 'process']);
Route::post('/chat-ai', [AIController::class, 'chat']);
