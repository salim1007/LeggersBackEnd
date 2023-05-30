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
Route::get('view-product-boykids', [ProductController::class, 'boykids']);
Route::get('view-product-girlkids', [ProductController::class, 'girlkids']);
Route::get('view-product-menOfficial', [ProductController::class, 'menOfficial']);
Route::get('view-product-menCasual', [ProductController::class, 'menCasual']);
Route::get('view-product-womenOfficial', [ProductController::class, 'womenOfficial']);
Route::get('view-product-womenCasual', [ProductController::class, 'womenCasual']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
