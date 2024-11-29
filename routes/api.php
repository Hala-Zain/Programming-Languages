<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('regester',[\App\Http\Controllers\AuthController::class,'register']);
Route::post('login',[\App\Http\Controllers\AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function (){
    Route::get('logout',[\App\Http\Controllers\AuthController::class,'logout']);
});
