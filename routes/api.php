<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::apiResource('/tasks', TaskController::class)->middleware('auth:sanctum');

Route::apiResource('/categories', CategoryController::class)->only('index','store')->middleware('auth:sanctum');


//Route::get('/categories/show/{category}', [CategoryController::class, 'show'])->name('categories.show')->middleware('auth');

