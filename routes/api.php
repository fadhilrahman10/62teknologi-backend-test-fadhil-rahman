<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/businesses', \App\Http\Controllers\Api\CreateBusinessController::class);
Route::get('/businesses/search', \App\Http\Controllers\Api\SearchBusinessController::class);
Route::put('/businesses/{id}', \App\Http\Controllers\Api\UpdateBusinessController::class);
Route::delete('/businesses/{id}', \App\Http\Controllers\Api\DeleteBusinessController::class);
