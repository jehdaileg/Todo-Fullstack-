<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Arr;



Route::apiResource('/tasks', TaskController::class)->middleware('auth:sanctum');

Route::apiResource('/categories', CategoryController::class)->middleware('auth:sanctum');

