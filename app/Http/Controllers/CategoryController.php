<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CategoryController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Categories/Index', [
            'categories' => Category::all()->map(function($category){
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'image' => asset('storage/' .$category->image),
                ];
            })
        ]);
       // return CategoryResource::collection(Category::all());

    }

    public function create()
    {
        return Inertia::render('Categories/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $data = $request->validate([

            'name' => ['required', 'string', 'max:250'],
            'image' => ['image', 'mimes:jpg,png,jpeg']

        ]);

        $image = request()->file('image');
       /* $imageOriginaleName = $image->getClientOriginalName();

        $path = request()->file('image')->storePubliclyAs('public/images/categories', $imageOriginaleName);
      */
        $path = $image->store('categories', 'public');

       Category::query()->create([
           'name' => $data['name'],
           'image' => $path
       ]);

       return redirect()->route('tasks.create');

/*
        return CategoryResource::make(

             v-if="form.progress"v-if="form.progress"

        ); */
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //

        return CategoryResource::make($category);

    }

    public function edit(Category $category)
    {
       $image = $category->image;

       return Inertia::render('Categories/Edit', [
            'category' => $category,
            'image' => asset('storage/' .$image)
       ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Category $category, Request $request)
    {
        $image = $category->image;

        $data = $request->validate([

            'name' => ['required', 'string', 'max:250'],
            'image' => ['image', 'mimes:jpg,png,jpeg']

        ]);

        if(request()->file('image')){

            Storage::delete('public/' .$category->image);

            $image = request()->file('image')->store('categories', 'public');

        }

       $category->update([
        'name' => $data['name'],
        'image' => $image
       ]);

       return Redirect::route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        Storage::delete('public/' .$category->image);

        $category->delete();

        return Redirect::route('categories.index');
    }
}
