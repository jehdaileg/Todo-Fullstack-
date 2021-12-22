<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

/*
$user = User::query()->first();


if(!auth()->check())
    Auth::login($user); */

//if (auth()->attempt(['email' => 'franssen@gmail.com', 'password' => 'secret'])){

    Auth::login(User::query()->firstWhere('name', 'franssen'));
//}


//Route::get('/', [TaskController::class, 'index']);

Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
