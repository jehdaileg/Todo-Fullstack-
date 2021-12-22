<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Arr;



Route::apiResource('/tasks', TaskController::class)->middleware('auth:sanctum');

Route::apiResource('/categories', CategoryController::class)->only('index','store')->middleware('auth:sanctum');


//Route::get('/categories/show/{category}', [CategoryController::class, 'show'])->name('categories.show')->middleware('auth');

Route::apiResource('/categories', CategoryController::class)->except('update', 'delete')->middleware('auth:sanctum');
