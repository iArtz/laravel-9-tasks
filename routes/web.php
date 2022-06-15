<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

Route::get('/', function () {
    error_log("INFO: GET /");
    return view('tasks', [
        'tasks' => Task::orderBy('created_at', 'asc')->get()
    ]);
});

/**
 * Add new Task
 */

 Route::post('/task', function(Request $request) {
    error_log("INFO: POST /task");
    $validator = FacadesValidator::make($request->all(), [
        'name' => 'required|max:255'
    ]);

    if ($validator->failed()) {
        error_log("ERROR: Add task failed.");
        return redirect('/')->withInput()->withErrors($validator);
    }

    $task = new Task;
    $task->name = $request->name;
    $task->save();

    return redirect('/');
 });

 /**
  * Delete Task
  */

  Route::delete('/task/{id}', function($id) {
    error_log("INFO: Delete /task/$id");
    Task::findOrFail($id)->delete();

    return redirect('/');
  });
