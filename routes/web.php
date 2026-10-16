<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/demo-login', [AuthController::class, 'demoLogin'])->name('demo.login');
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');
Route::post('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout']); // Fallback GET logout

// Gamification EXP Sync
Route::post('/api/update-exp', [AuthController::class, 'updateExp'])->name('api.update-exp');

// Loma.AI Studio Learning Dashboard
Route::get('/app', function () {
    $user = Auth::user();

    $module = null;
    $sources = collect();
    $flashcards = collect();

    try {
        $module = DB::table('learning_modules')->first();
        $sources = DB::table('learning_sources')->get();
        $flashcards = DB::table('learning_flashcards')->get();
    } catch (\Throwable $e) {
        // Fallback gracefully so /app page always renders even if database is migrating or empty
    }

    return view('welcome', compact('user', 'module', 'sources', 'flashcards'));
})->name('app');

Route::get('/studio', function () {
    return redirect()->route('app');
});
