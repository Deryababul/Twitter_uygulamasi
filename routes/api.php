<?php

use App\Http\Controllers\FollowController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth'])->post('/tweets', 'TweetController@create');
Route::post('/register', [UserController::class, 'register']);

Route::controller(UserController::class)->prefix('users')->middleware('auth:sanctum')-> group(function(){

    Route::post('/login', [UserController::class, 'login']);
    Route::post('/create', [TweetController::class, 'create']);
    Route::get('/user', [UserController::class,'user']);
    });
    Route::middleware(['auth', 'check.user.authentication'])->middleware('auth:sanctum')->group(function(){
        Route::get('/list', [TweetController::class,'list']);
        Route::delete('/delete/{id}',[TweetController::class, 'delete']);
    });
    Route::controller(FollowController::class)->middleware('auth:sanctum')->group(function(){
        Route::get('/sendFollowRequest', 'sendFollowRequest');
        Route::get('/acceptFollowRequest','acceptFollowRequest');
        Route::get('/rejectFollowRequest','rejectFollowRequest');
        Route::get('/followers', 'followers');
        Route::get('count', 'count');
    });
    