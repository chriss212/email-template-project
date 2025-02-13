<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1'], function () {
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', action: [UserController::class, 'show']);
    Route::put('/users/{user}', [UserController::class,'update']);
    Route::delete('/users/{user}', [UserController::class,'delete']);
});