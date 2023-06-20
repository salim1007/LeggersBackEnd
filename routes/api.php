<?php

use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CheckoutController;
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


//Products
Route::post('add-product', [ProductController::class, 'add']);
Route::get('view-product-boykids', [ProductController::class, 'boykids']);
Route::get('view-product-girlkids', [ProductController::class, 'girlkids']);
Route::get('view-product-menOfficial', [ProductController::class, 'menOfficial']);
Route::get('view-product-menCasual', [ProductController::class, 'menCasual']);
Route::get('view-product-womenOfficial', [ProductController::class, 'womenOfficial']);
Route::get('view-product-womenCasual', [ProductController::class, 'womenCasual']);
Route::get('edit-product/{id}', [ProductController::class, 'edit']);
Route::put('update-product/{id}', [ProductController::class, 'update']);
Route::get('getAllProducts', [ProductController::class, 'getAllProducts']);
Route::delete('deleteProduct/{id}', [ProductController::class, 'delete']);

Route::get('viewproductdetails/{categoryid}/{section}/{namee}', [ProductController::class, 'getProductDetails']);

Route::get('fetch-products', [ProductController::class, 'allproducts']);

//Cart........
Route::post('add-to-cart', [CartController::class, 'add']);
Route::get('cart', [CartController::class, 'viewCart']);
Route::put('cart-updateqty/{cart_id}/{scope}', [CartController::class, 'updateQty']);
Route::delete('delete-cartItem/{cart_id}', [CartController::class, 'deleteCartItem']);

//Orders......
Route::post('place-order', [CheckoutController::class, 'placeorder']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
