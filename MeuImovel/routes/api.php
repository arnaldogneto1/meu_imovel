<?php

use App\Http\Controllers\Api\RealStateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->namespace('Api')->group(function() {
    Route::prefix('real_states')->group(function() {
        Route::get('/', [RealStateController::class, 'index']);
        Route::get('/{id}', [RealStateController::class, 'show']);
        Route::post('/', [RealStateController::class, 'store']);
        Route::put('/{id}', [RealStateController::class, 'update']);
        Route::patch('/{id}', [RealStateController::class, 'update']);
        Route::delete('/{id}', [RealStateController::class, 'destroy']);
    });
});
