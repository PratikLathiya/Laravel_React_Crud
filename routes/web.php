<?php

// use App\Http\Controllers\ProfileController;
// use Illuminate\Foundation\Application;
// use Illuminate\Support\Facades\Route;
// use Inertia\Inertia;

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('/posts', function () {
//         return Inertia::render('Posts/Index');
//     })->name('posts.index');

//     Route::get('/posts/create', function () {
//         return Inertia::render('Posts/Create');
//     })->name('posts.create');

//     Route::get('/posts/{id}/edit', function ($id) {
//         return Inertia::render('Posts/Edit', ['id' => $id]);
//     })->name('posts.edit');
// });

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Redirect root to posts index if authenticated, otherwise to login
Route::get('/', function () {
    return auth()->check() ? redirect()->route('posts.index') : redirect()->route('login');
});

// Authentication routes
Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout')
    ->middleware('auth');

// Posts routes
Route::middleware(['auth'])->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
});

// API routes for CRUD operations
Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::apiResource('posts', PostController::class)->except(['index', 'create', 'edit']);
});

require __DIR__.'/auth.php';
