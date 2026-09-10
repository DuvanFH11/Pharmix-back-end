<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function(){
    //LOGIN Y LOGOUT
    Route::get('/user', [UserController::class, 'showUser']);
    Route::post('/logout',[UserController::class, 'logout']);

    //USERS
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{user}', [UserController::class, 'show']);

    //PRODUCTS
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    
    //ROLES
    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::post('/roles/{role}', [RoleController::class, 'show']);

    // APPOINTMENTS
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::post('/appointmets', [AppointmentController::class, 'store']);
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show']);

    //CATEGORIES
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);

    //APPOINTMENTS

});

Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);
