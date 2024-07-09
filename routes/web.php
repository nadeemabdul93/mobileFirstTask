<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::middleware(['auth', 'user-access:user'])->group(function () {  
    Route::get('/home', [HomeController::class, 'index'])->name('home'); 


});

Route::middleware(['auth', 'user-access:admin'])->group(function () {  
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
    Route::get('/admin/editUser/{id}', [AdminController::class, 'editUser'])->name('admin.editUser');
    Route::post('/admin/updateUser', [AdminController::class, 'updateUser'])->name('admin.updateUser');
    Route::get('/admin/deleteUser/{id}', [AdminController::class, 'delete'])->name('admin.deleteUser');
});
