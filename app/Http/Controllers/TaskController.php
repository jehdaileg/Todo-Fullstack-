<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\TaskResource;
use App\Http\Requests\CreateTaskRequest;

class TaskController
{

    /*public function __construct()
    {
        $this->middleware('auth');

    } */ //outsider
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return TaskResource::collection(Task::all());


    }

    /**
     * Store a newly created resource in storage.
     */
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

        return TaskResource::make(
            $task->fresh()

        );
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
