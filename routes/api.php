<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Users\CategoryController as UsersCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1/admin')->middleware('auth:sanctum')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::get('/category/search', [CategoryController::class, 'search']);
    // change status
    Route::put('/category/change-status/{id}', [CategoryController::class, 'changeStatus']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::prefix('v1')->group(function () {
    Route::get('get-all-category-name', [UsersCategoryController::class, 'getAllCategoryName']);
    Route::get('get-all-category', [UsersCategoryController::class, 'getAllCategory']);
    Route::get('/category/{id}', [UsersCategoryController::class, 'getProductByCategoryId']);
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::post('/login', [AuthController::class, 'login']);
});
