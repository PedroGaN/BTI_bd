<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\FoodController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('foods')->group(function () {
    Route::post('/new',[FoodController::class,"createUser"]);
    Route::post('/update',[FoodController::class,"updateUser"]);
    Route::get('/search/{name}',[FoodController::class,"searchFood"]);
    //TEST TOKEN:
    Route::post('/test',[FoodController::class,"updateUser"])->middleware('checkLogged');
});

Route::prefix('libraries')->group(function () {
    Route::post('/new',[LibraryController::class,"createLibrary"]);
    Route::post('/update',[LibraryController::class,"updateLibrary"]);
});

Route::prefix('users')->group(function () {
    Route::post('/new',[UserController::class,"createUser"]);
    Route::post('/update',[UserController::class,"updateUser"]);
    Route::post('/login',[UserController::class,"loginUser"]);
    //Route::post('/forgotPassword',[UserController::class,"recoverPassword"]);
});