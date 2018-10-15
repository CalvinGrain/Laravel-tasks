<?php

namespace App\Http\Controllers;

use Validator;
use App\Tasks;
use App\Comments;
use Illuminate\Http\Request;
use App\Http\Resources\TasksResource;
use App\Http\Resources\ErrorsResource;

class TasksController extends Controller
{
    public function getTasks(Tasks $tasks, Request $request)
    {
        return new TasksResource($tasks->filter($request)->get());
    }

    public function postTask(Tasks $task, Request $request)
    {
        $validation = Validator::make($request->all(),[
            'title'       => 'bail|required|max:32',
            'description' => 'required',
            'assignee_id' => 'required|numeric|exists:users,id',
        ]);

        if($validation->fails())
        {
            $errors = [];
            foreach($validation->errors()->messages() as $title => $detail){
                $errors[] = ['title' => $title,'detail' => $detail[0]];
            }
            return response()->json(new ErrorsResource(
                ['errors' => $errors]
            ), 400);
        }
        else
        {
            $task->create([
                'title' => $request->title,
                'description' => $request->description,
                'assignee_id' => $request->assignee_id
            ]);

            return response()->json('OK', 201);
        }
    }

    public function postComment($id, Comments $comment, Request $request)
    {
        $data = array_merge(
            ['task_id' => $id],
            $request->all()
        );

        $validation = Validator::make($data,[
            'comment' => 'bail|required',
            'task_id' => 'required|numeric|exists:tasks,id'
        ]);

        if($validation->fails())
        {
            $errors = [];
            foreach($validation->errors()->messages() as $title => $detail){
                $errors[] = ['title' => $title,'detail' => $detail[0]];
            }
            return response()->json(new ErrorsResource(
                ['errors' => $errors]
            ), 400);
        }
        else
        {
            $comment->create([
                'author_id' => $request->user()->id,
                'task_id' => $request->task_id,
                'comment' => $request->comment
            ]);

            return response()->json('OK', 201);
        }
    }
}
