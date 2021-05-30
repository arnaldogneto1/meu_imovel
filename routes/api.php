<?php

use App\Http\Controllers\Api\Auth\LoginJWTController;
use App\Http\Controllers\Api\RealStateController;
use App\Http\Controllers\Api\RealStatePhotoController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\RealStateSearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('v1')->namespace('Api')->group( function() {

        //LOGIN
        Route::post('login', [LoginJWTController::class, 'login']);
        Route::get('logout', [LoginJWTController::class, 'logout']);
        Route::get('refresh', [LoginJWTController::class, 'refresh']);

        //SEARCH
        Route::get('search', [RealStateSearchController::class, 'index']);
        Route::get('search/{real_state_id}', [RealStateSearchController::class, 'show']);

        //LOGGED ROUTES
        Route::group(['middleware' => ['jwt.auth']], function () {
            Route::prefix('real-states')->group(function() {
                Route::get('/', [RealStateController::class, 'index']);
                Route::get('{id}', [RealStateController::class, 'show']);
                Route::post('/', [RealStateController::class, 'store']);
                Route::put('{id}', [RealStateController::class, 'update']);
                Route::patch('{id}', [RealStateController::class, 'update']);
                Route::delete('{id}', [RealStateController::class, 'destroy']);
            });

            Route::prefix('users')->group(function() {
                Route::get('/', [UserController::class, 'index']);
                Route::get('{id}', [UserController::class, 'show']);
                Route::post('/', [UserController::class, 'store']);
                Route::put('{id}', [UserController::class, 'update']);
                Route::patch('{id}', [UserController::class, 'update']);
                Route::delete('{id}', [UserController::class, 'destroy']);
            });

            Route::prefix('categories')->group(function() {
                Route::get('/', [CategoryController::class, 'index']);
                Route::get('{id}', [CategoryController::class, 'show']);
                Route::get('{id}/real-states', [CategoryController::class, 'realState']);
                Route::post('/', [CategoryController::class, 'store']);
                Route::put('{id}', [CategoryController::class, 'update']);
                Route::patch('{id}', [CategoryController::class, 'update']);
                Route::delete('{id}', [CategoryController::class, 'destroy']);
            });

            Route::prefix('photos')->group(function() {
                Route::put('set-thumb/{photoId}/{realStateId}', [RealStatePhotoController::class, 'setThumb']);
                Route::delete('{id}', [RealStatePhotoController::class, 'remove']);
            });
        });
});
