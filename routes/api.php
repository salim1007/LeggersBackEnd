<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

//Category
Route::post('add-category', [CategoryController::class, 'add']);
Route::get('get-category', [CategoryController::class, 'getCategory']);
Route::get('edit-category/{id}', [CategoryController::class, 'edit']);
Route::put('update-category/{id}', [CategoryController::class, 'update']);


//Product
Route::post('add-product', [ProductController::class, 'add']);
Route::get('view-products', [ProductController::class, 'view']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
