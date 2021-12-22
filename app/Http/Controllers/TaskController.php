<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\TaskResource;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Resources\CategoryResource;
use Inertia\Inertia;

class TaskController
{

    public function index()
    {
      /*  return Inertia::render('Tasks/Index', [
            'tasks' => Task::query()
                ->with('category', 'user')
                ->when(request('completed'), fn (Builder $q) => $q->where('completed', true))
                ->whereCompleted(false)
                ->whereBelongsTo(auth()->user())
                ->latest()
                ->get(['id', 'title', 'completed', 'created_at', 'category_id', 'user_id'])
                ->map(fn ($task) => [

                    'id' => $task->id,
                    'title' => $task->title,
                    'completed' => $task->completed,
                    'category' => $task->category,
                    'created_at' => $task->created_at,
                    'user'=> $task->user
                ])
        ]);  */

        $tasks = Task::query()
        ->whereCompleted(false)
        ->with('category')
        ->when(request('completed'), fn (Builder $q) => $q->whereCompleted(), fn (Builder $q) => $q->whereCompleted(false))
        ->when(request('categories'), fn (Builder $q) => $q
            ->whereHas('category', function (Builder $q) {
                return $q->whereIn('name', explode('+', request('categories')));
            }))
        ->whereBelongsTo(auth()->user())
        ->latest()
        ->get();

        return Inertia::render('Tasks/Index', [
            'tasks' => TaskResource::collection($tasks),
            'categories' => CategoryResource::collection(Category::all())
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        return Inertia::render('Tasks/Create', [
            'categories' => CategoryResource::collection(Category::all())
        ]);

    }
    public function store()
    {
        request()->user()->tokenCan('tasks.store');

        $data = request()->validate([
            'title' => 'required|string',
            'category_id' => ['filled', 'integer', Rule::exists('categories', 'id')]

        ], request()->all());

        $task = Task::create(
            array_merge($data, ['user_id' => auth()->id()])
        );

        /*return TaskResource::make(
            $task->fresh()

        );*/
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //

        return TaskResource::make($task);


        //return TaskResource::make($task);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Task $task)
    {
        request()->user()->tokenCan('tasks.update');

        $data = request()->validate([
            'title' => 'required|string',
            'category_id' => ['filled', 'integer', Rule::exists('categories', 'id')]

        ], request()->all());

        TaskResource::make(
            tap($task)->update($data)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //



        return TaskResource::make(

            tap($task)->delete()

        );
    }
}
