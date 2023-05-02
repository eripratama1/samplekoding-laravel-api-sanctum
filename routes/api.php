<?php

use App\Http\Controllers\Api\v1\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Protected routes hanya admin atau 
 * User yang sudah terautentikasi saja 
 * yang bisa mengakses route tersebut
 */
Route::group(['middleware' => ['auth:sanctum']],function(){
    Route::post('logout',[\App\Http\Controllers\Api\AuthController::class,'logout'])->name('logout');
    Route::post('/products',[\App\Http\Controllers\Api\v1\ProductController::class,'store']);
    Route::patch('/products/{id}',[\App\Http\Controllers\Api\v1\ProductController::class,'update']);
    Route::delete('/products/{id}',[\App\Http\Controllers\Api\v1\ProductController::class,'destroy']);
});

/**
 * Route public dan autehtifikasi ( Register & Login )
 */
Route::get('products',[\App\Http\Controllers\Api\v1\ProductController::class,'index']);
Route::get('products/{id}',[\App\Http\Controllers\Api\v1\ProductController::class,'show']);
Route::post('register',[\App\Http\Controllers\Api\AuthController::class,'register'])->name('register');
Route::post('login',[\App\Http\Controllers\Api\AuthController::class,'login'])->name('login');