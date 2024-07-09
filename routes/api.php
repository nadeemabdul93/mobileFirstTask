<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/products', [App\Http\Controllers\ProductsController::class, 'store']);
Route::get('/products', [App\Http\Controllers\ProductsController::class, 'index']);
Route::get('/products/{id}', [App\Http\Controllers\ProductsController::class, 'show']);
Route::put('/products/{id}', [App\Http\Controllers\ProductsController::class, 'update']);
Route::delete('/products/{id}', [App\Http\Controllers\ProductsController::class, 'destroy']);
