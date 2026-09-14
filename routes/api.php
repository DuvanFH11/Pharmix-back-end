<?php
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\JobTitleController;
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
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::post('/users/save/{id?}', [UserController::class, 'storeOrUpdate']);

    //PRODUCTS
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::post('/products/save/{id?}', [ProductController::class, 'storeOrUpdate']);
    
    //ROLES
    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/roles/{role}', [RoleController::class, 'show']);
    Route::post('/roles/save/{id?}', [RoleController::class, 'storeOrUpdate']);

    // APPOINTMENTS
    Route::get('/job_titles', [JobTitleController::class, 'index']);
    Route::get('/job_titles/{job_title}', [JobTitleController::class, 'show']);
    Route::post('/job_titles/save/{id?}', [JobTitleController::class, 'storeOrUpdate']);

    //CATEGORIES
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);

});

Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);
