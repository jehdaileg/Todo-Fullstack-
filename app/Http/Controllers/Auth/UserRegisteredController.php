<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Inertia\Inertia;

class UserRegisteredController extends Controller
{
    //

    public function create(): \Inertia\Response
    {
        return Inertia::render('Auth/Register');
    }

   public function store() : \Illuminate\Http\RedirectResponse
   {
        $data = request()->validate([
            'name' => ['required'],
            'firstname' => ['required', 'string'],
            'lastname' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6', 'confirmed']
        ], request()->all());

    $user = User::query()->create($data);

    Auth::login($user, remember: true);

    return redirect()->route('profil.create');
   }
}
