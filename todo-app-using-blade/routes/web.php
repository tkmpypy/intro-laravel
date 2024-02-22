<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [TodoController::class, 'show']);
Route::post('/store', [TodoController::class, 'store'])->name('store');
Route::patch('/done', [TodoController::class, 'done'])->name('done');
Route::patch('/delete', [TodoController::class, 'delete'])->name('delete');
