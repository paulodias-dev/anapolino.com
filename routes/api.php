<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ListingController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    // Auth
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Public routes
    Route::get('/plans', [PlanController::class, 'index']);
    Route::get('/plans/{plan}', [PlanController::class, 'show']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);
    Route::get('/categories/{category}/listings', [CategoryController::class, 'showWithListings']);
    Route::get('/categories/featured', [CategoryController::class, 'withListings']);

    Route::get('/listings', [ListingController::class, 'index']);
    Route::get('/listings/{listing}', [ListingController::class, 'show']);



    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        // Listings
        Route::post('/listings', [ListingController::class, 'store']);
        Route::put('/listings/{listing}', [ListingController::class, 'update']);
        Route::delete('/listings/{listing}', [ListingController::class, 'destroy']);

        // User
        Route::get('/user', [UserController::class, 'show']);
        Route::put('/user', [UserController::class, 'updateProfile']);
    });
});
