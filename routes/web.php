<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserUpdateProfilController;
use App\Http\Controllers\Auth\UserRegisteredController;
use App\Http\Controllers\Auth\UserAuthenticatedController;


/* test */
/*
Auth::login(User::query()->firstOrCreate([
    'email' => 'romus@gmail.com',
    'password' => '00000000',
    'name' => 'romjul'
]));
 */
/*
Auth::logout(User::query()->firstOrCreate([
    'email' => 'romus@gmail.com',
    'password' => '00000000',
    'name' => 'romjul'
]));  */

/*for not connected or not register users */

Route::middleware('guest')->group(function (){

    Route::get('/register', [UserRegisteredController::class, 'create'])->name('register.create');
    Route::post('/register', [UserRegisteredController::class, 'store'])->name('register.store');

    Route::get('/login', [UserAuthenticatedController::class, 'create'])->name('login.index');
    Route::post('/login', [UserAuthenticatedController::class, 'store'])->name('login.store');

});

/* Only for connected users */



Route::middleware('auth')->group(function (){

    Route::post('/logout', [UserAuthenticatedController::class, 'destroy'])->name('login.destroy');

        //avatar
    Route::get('/user-update-profil', [UserUpdateProfilController::class, 'create'])->name('profil.create');
    Route::post('/user-update-profil', [UserUpdateProfilController::class, 'store'])->name('profil.store');

    Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::put('/update/{task}', [TaskController::class, 'update']);
    Route::delete('/destroy/{task}', [TaskController::class, 'destroy']);
    Route::post('/complete/all', [TaskController::class, 'completeAll']);
    Route::post('/destroy/all', [TaskController::class, 'deleteAll']);
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');

});
