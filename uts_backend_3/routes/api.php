<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AuthController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// membuat route NewsController
Route::get('/news', [NewsController::class, 'index']);
Route::post('/news', [NewsController::class, 'store']);
Route::put('/news/{id}', [NewsController::class, 'update']);
Route::delete('/news/{id}', [NewsController::class, 'destroy']);
Route::patch('/news/{id}', [NewsController::class, 'partialUpdate']);

Route::get('/news/search/{title}', [NewsController::class, 'search']);     // Search Resource by title
Route::get('/news/category/sport', [NewsController::class, 'sport']);      // Get Sport Resource
Route::get('/news/category/finance', [NewsController::class, 'finance']);  // Get Finance Resource
Route::get('/news/category/automotive', [NewsController::class, 'automotive']); // Get Automotive Resource

