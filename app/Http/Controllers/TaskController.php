<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(int $listId): array
    {
        $user = User::findOrFail(Auth::user()->id);

        $list = $user->taskLists()->find($listId); 

        return $list->tasks()->get();
    }
    
    public function view(int $listId, int $id): Task
    {
        $user = User::findOrFail(Auth::user()->id);

        $list = $user->taskLists()->find($listId); 

        return $list->tasks()->findOrFail($id);
    }

    public function create(Request $request, int $listId): Response
    {
        $task = new Task;

        $task->task_list_id = $listId;
        $task->title = $request->input('title');
        $task->description = $request->input('description');

        $status = $task->save();
        $responseCode = $status ? 200 : 400;

        return response([
            'status' => $status
        ], $responseCode);
    }

    public function update(Request $request, int $listId, int $id): Response
    {
        $task = Task::findOrFail($id);

        if($title = $request->input('title')){
            $task->title = $title;
        }

        if($description = $request->input('description')){
            $task->description = $description;
        }

        if($complete = $request->input('complete')){
            $task->complete = $complete;
        }

        $status = $task->save();
        $responseCode = $status ? 200 : 400;

        return response([
            'status' => $status
        ], $responseCode);
    }
}
