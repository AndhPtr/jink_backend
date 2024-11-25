<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageContentController;
use App\Http\Controllers\LinkContentController;
use App\Http\Controllers\TextContentController;
use App\Http\Controllers\ImageContentController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('page-content')->group(function () {
    Route::get('/{id}', [PageContentController::class, 'show']);  // Show page with content
    Route::post('/', [PageContentController::class, 'store']);    // Create page
    Route::put('/{id}', [PageContentController::class, 'update']); // Update page
    Route::delete('/{id}', [PageContentController::class, 'destroy']); // Delete page
});

Route::prefix('link-content')->group(function () {
    Route::post('/', [LinkContentController::class, 'store']);  // Create link content
    Route::get('/', [LinkContentController::class, 'index']);   // Get all link content
    Route::put('/{id}', [LinkContentController::class, 'update']); // Update link content
    Route::delete('/{id}', [LinkContentController::class, 'destroy']); // Delete link content
});

Route::prefix('text-content')->group(function () {
    Route::post('/', [TextContentController::class, 'store']);  // Create text content
    Route::get('/', [TextContentController::class, 'index']);   // Get all text content
    Route::put('/{id}', [TextContentController::class, 'update']); // Update text content
    Route::delete('/{id}', [TextContentController::class, 'destroy']); // Delete text content
});

Route::prefix('image-content')->group(function () {
    Route::post('/', [ImageContentController::class, 'store']);  // Create image content
    Route::get('/', [ImageContentController::class, 'index']);   // Get all image content
    Route::put('/{id}', [ImageContentController::class, 'update']); // Update image content
    Route::delete('/{id}', [ImageContentController::class, 'destroy']); // Delete image content
});

Route::middleware('auth')->group(function () {
    Route::get('pages', [PageController::class, 'index']);   // Get all pages for the authenticated user
    Route::get('pages/{id}', [PageController::class, 'show']); // Show a single page
    Route::post('pages', [PageController::class, 'store']);    // Create a new page
    Route::put('pages/{id}', [PageController::class, 'update']); // Update an existing page
    Route::delete('pages/{id}', [PageController::class, 'destroy']); // Delete a page
});

Route::post('/login', [UserController::class, 'login']); // Public route for login

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/{id}', [UserController::class, 'show']);   // Get a specific user
        Route::post('/', [UserController::class, 'store']);     // Create a new user
        Route::put('/{id}', [UserController::class, 'update']); // Update an existing user
        Route::delete('/{id}', [UserController::class, 'destroy']); // Delete a user
    });

    Route::post('/logout', [UserController::class, 'logout']); // Protected route for logout
});
