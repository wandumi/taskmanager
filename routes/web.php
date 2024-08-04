<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;

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
    return view('welcome');
});

Route::get('/', [ProjectController::class, 'index']);
Route::resource('tasks', TaskController::class);
Route::post('tasks/reorder', [TaskController::class, 'order'])->name('tasks.reorder');
Route::resource('projects', ProjectController::class);
