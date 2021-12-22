<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Arr;

Route::post('/tokens/create', function () {
    $data = validator()->validate(
        [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
            'device_name' => ['required', 'string']
        ],
        request()->all()
    );

    throw_unless(
        auth()->attempt(Arr::only($data, ['email', 'password'])),
        new AuthenticationException('Unauthenticated')
    );

    $token = request()->user()->createToken($data['device_name'], [
        'tasks.index','tasks.show','tasks.store',
        'tasks.update',
        'tasks.destroy',
    ]);

    return response()->json(['token' => $token->plainTextToken]);
});

Route::apiResource('/tasks', TaskController::class)->middleware('auth:sanctum');

Route::apiResource('/categories', CategoryController::class)->except('update', 'delete')->middleware('auth:sanctum');
