<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserAuthenticatedController extends Controller
{
    //
    public function create(): \Inertia\Response
    {
        return Inertia::render('Auth/Login');
    }

    public function store(): \Illuminate\Http\RedirectResponse
    {
        $data = request()->validate([
            'email' => ['required', 'string'],
            'password' => 'required', 'string'
        ], request()->all());


        if (auth()->attempt($data, remember: true)) {
           // return $data;
            request()->session()->regenerate();
            return redirect()->route('tasks.index');
        }

        return back()->withErrors([
            'email' => 'Your credentials do not match with our datas, please check your email or your password and retry !'
        ]);
    }

    public function destroy(): \Illuminate\Http\RedirectResponse
    {
        auth(guard: 'web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login.index');
    }
}
