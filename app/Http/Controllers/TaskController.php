<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

use App\Http\Requests\TaskUpdate;
use App\Http\Requests\StoreTask;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Task $task)
    {
        //
        return response()->json($task->paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTask $request, Task $task)
    {
        //
        $new = $task->create($request->all());
        return response()->json(['status'=> true, 'messages' => 'Task succesfully created!', 'data'=> $new]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskUpdate $request, Task $task)
    {
        //

        $task->update($request->all());

        return response()->json(['status'=> true, 'messages' => 'Task changes saved succesfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
        $task->delete();
        return response()->json(['status'=> true, 'messages' => 'Task succesfully deleted!']);
    }
}
