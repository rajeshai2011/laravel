<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Api\PostController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register',[Auth::class,'register']);
Route::post('/login',[Auth::class,'login']);


Route::middleware('auth:sanctum')->group(function() {
   Route::resource('/posts',PostController::class);
});
