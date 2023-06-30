<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
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
