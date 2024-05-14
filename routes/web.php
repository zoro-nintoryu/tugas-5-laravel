<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\Web\UserController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserManagementController;



Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::get('/register', [UserController::class, 'showRegisterForm']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::middleware('role:user')->group(function () {
        Route::get('/products', [ProductController::class, 'getProduct'])->name('get_product');
    });

    Route::middleware('role:superadmin')->group(function () {
      Route::get('/UserManagementController', [UserManagementController::class, 'getAdmin'])->name('admin_page');
        Route::get('/products', [ProductController::class, 'getProduct'])->name('get_product');
    });
});
Route::post('/{user}/post-request', [UserController::class, 'postRequest'])->name('postRequest');
Route::get('/{user}/tambah-product', [UserController::class, 'handleRequest'])->name('form_product');
Route::get('/products', [UserController::class, 'getProduct'])->name('get_product');
Route::get('/{user}/product/{product}', [UserController::class, 'editProduct'])->name('edit_product');
Route::put('/{user}/product/{product}/update', [UserController::class, 'updateProduct'])->name('update_product');
Route::post('/{user}/product/{product}/delete', [UserController::class, 'deleteProduct'])->name('delete_product');
Route::get('/profile/{user}', [UserController::class, 'getProfile'])->name('get_profile');

Route::get('/admin/{user}/list-products', [UserController::class, 'getAdmin'])->name('admin_page');



// Route::post('/posts/{post}/delete', [PostController::class, 'delete']);
