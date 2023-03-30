<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthApiController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('v1')->group(function (){
    Route::post('register',[AuthApiController::class,'register'])->name('auth.register');
    Route::post('login',[AuthApiController::class,'login'])->name('auth.login');

    Route::middleware(['auth:sanctum'])->group(function (){

        Route::post('logout',[AuthApiController::class,'logout'])->name('auth.logout');
        Route::post('token',[AuthApiController::class,'token'])->name('auth.token');

        Route::apiResource('products',\App\Http\Controllers\ProductApiController::class);
        Route::apiResource("photos",\App\Http\Controllers\PhotoApiController::class);

    });
});
