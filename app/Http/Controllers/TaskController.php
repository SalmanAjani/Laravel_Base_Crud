<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function deleteTask(Task $task){
        if(auth()->user()->id === $task['user_id']){
            $task->delete();
        }
        return redirect('/');
    }

    // Task $task -> gives us the task we are trying to update
    // Request $request -> gives us the form data
    public function editTask(Task $task, Request $request){
        if(auth()->user()->id !== $task['user_id']){
            return redirect('/');
        }

        $formData = $request->validate([
            'title' => 'required',
            'desc' => 'required',
        ]);

        $formData['title'] = strip_tags($formData['title']);
        $formData['desc'] = strip_tags($formData['desc']);

        // update -> since we are taking an instance of Task model, this method that allows us to update data, no SQL code required
        $task->update($formData);
        return redirect('/');
    }

    public function editPage(Task $task){
        if(auth()->user()->id !== $task['user_id']){
            return redirect('/');
        }

        return view('edit-task', ['task' => $task]);
    }

    public function createTask(Request $request){
        $formData = $request->validate([
            'title' => 'required',
            'desc' => 'required'
        ]);

        $formData['title'] = strip_tags($formData['title']);
        $formData['desc'] = strip_tags($formData['desc']);
        $formData['user_id'] = auth()->id();
        Task::create($formData);
        return redirect('/');
    }
}
