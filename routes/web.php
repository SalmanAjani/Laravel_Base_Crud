<?php

// use App\Models\Task;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $tasks = [];
    if(auth()->check()){
        $tasks = auth()->user()->usersTasks()->latest()->get();
    }
    // $tasks = Task::where('user_id', auth()->id())->get();
    // $tasks = Task::all();
    return view('home', ['tasks' => $tasks]);
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);

// Tasks routes
Route::post('/create-task', [TaskController::class, 'createTask']);