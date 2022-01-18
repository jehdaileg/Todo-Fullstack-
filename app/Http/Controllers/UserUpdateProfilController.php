<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class UserUpdateProfilController extends Controller
{
    //
    public function create()
    {
        return Inertia::render('Users/UpdateProfilUser');
    }

    public function store()
    {

        request()->validate([
            'avatar' => ['filled', 'image']
        ], request()->all());

        if(request()->file('avatar')){
            $name = request()->file('avatar')->getClientOriginalName();

            $src =  request()->file('avatar')->storePubliclyAs('avatars', time() .$name, 'public');

            request()->user()->update(['photo' => $src]);

            return redirect()->route('tasks.index');
        }

        return back();
    }
}
