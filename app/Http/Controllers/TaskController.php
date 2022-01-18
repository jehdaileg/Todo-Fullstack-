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
use InvalidArgumentException;

class TaskController
{

    public function index()
    {

        $tasks = Task::query()
        ->with('category')
        ->when(request('category'), fn(Builder $builder) =>
            $builder->whereRelation('category', 'name', request('category'))
        )
        ->when(request('statustask'), fn(Builder $builder) =>
            match(request('statustask')){
                'completed' => $builder->where('completed', true),
                'uncompleted' => $builder->where('completed', false),
                default => throw new InvalidArgumentException('Unsupported Status task')

            }
        )
        ->where('user_id', auth()->id())
        ->latest()
        ->get()
        ->transform(fn ($task) => [
            'id' => $task->id,
            'title' => $task->title,
            'completed' => $task->completed,
            'selected' => false,
            'hovered' => false
        ]);

        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
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
    public static function update(Task $task)
    {

       /* tap($task)->update(['completed' => $task->completed ? false: true ]);

        return back();  */

        $data = request()->validate([
            'title' => ['filled'],
            'completed' => ['filled'],
        ], request()->all());

        $task->update($data);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return back();
    }

    public function completeAll()
    {
        $data = request()->validate([
            'tasks' => ['array', 'filled'],
            'tasks.*' => Rule::exists('tasks', 'id')
        ], request()->all());

        Task::query()->find($data['tasks'])->each(fn (Task $task) => $task->update(['completed' => true]));

        return back();
    }

    public function deleteAll()
    {
        $data = request()->validate([
            'tasks' => ['array', 'filled'],
            'tasks.*' => Rule::exists('tasks', 'id')
        ], request()->all());


        Task::query()->find($data['tasks'])->each(fn(Task $task) => $task->delete());

        return back();
    }
}
