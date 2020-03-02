<?php

namespace App\Http\Controllers;

use App\TaskList;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskListController extends Controller
{    
    public function index()
    {
        $user = User::findOrFail(Auth::user()->id);

        return $user->taskLists()->get();
    }

    public function view(int $id)
    {
        $user = User::findOrFail(Auth::user()->id);

        return $user->taskLists()->findOrFail($id);
    }

    public function create(Request $request)
    {
        $list = new TaskList;

        $list->name = $request->input('name');
        $list->user_id = Auth::user()->id;

        $status = $list->save();
        $responseCode = $status ? 200 : 400;

        return response([
            'status' => $status
        ], $responseCode);
    }

    public function update(Request $request, int $id)
    {
        $list = TaskList::findOrFail($id);

        $list->name = $request->input('name');

        $status = $list->save();
        $responseCode = $status ? 200 : 400;

        return response([
            'status' => $status
        ], $responseCode);
    }
}
