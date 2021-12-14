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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //



        $data = request()->validate([
            'title' => 'required|string',
            'category_id' => ['filled', 'integer', Rule::exists('categories', 'id')]


        ], request()->all());



       // $task = Task::create($request->validated());

    /*   $task = Task::create($data);

       return TaskResource::make(
           $task->fresh()

       );  */

       return TaskResource::make(

        Task::query()->create($data)

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
    public function update(Request $request, Task $task)
    {
        //
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

        $task->delete()

      );




    }
}
