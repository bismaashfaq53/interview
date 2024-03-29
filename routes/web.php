<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;


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
    $data = [
        'apple',
        'orrange'
    ];
    return view('welcome');
});
Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/taskStore', [TaskController::class, 'store']);
Route::get('/completeTask/{taskId}', [TaskController::class, 'completeTask'])->name('completeTask');
Route::get('/fetchTasks', [TaskController::class, 'fetchTasks']);
Route::get('/deleteTask/{id}', [TaskController::class, 'deleteTask'])->name('deleteTask');

