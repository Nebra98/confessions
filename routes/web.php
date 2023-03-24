<?php

use Illuminate\Support\Facades\Auth;
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


Auth::routes();

Route::get('/', [App\Http\Controllers\ConfessionController::class, 'index'])->name('confessions');
Route::get('/confessions/create', [App\Http\Controllers\ConfessionController::class, 'create'])->name('confessions.create');
Route::post('/confessions', [App\Http\Controllers\ConfessionController::class, 'store'])->name('confessions.store');
Route::get('/sort/najstarije', [App\Http\Controllers\ConfessionController::class, 'sortAsc'])->name('confessions.sortAsc');
Route::get('/sort/najnovije', [App\Http\Controllers\ConfessionController::class, 'sortDsc'])->name('confessions.sortDsc');
Route::get('/sort/slucajno', [App\Http\Controllers\ConfessionController::class, 'sortRnd'])->name('confessions.sortRnd');

Route::get('confessions/{confession}', [App\Http\Controllers\ConfessionController::class, 'show'])->name('confessions.show');

Route::get('comments/commentslist/{confession}', [\App\Http\Controllers\CommentController::class, 'getComments']);
Route::resource('comments', \App\Http\Controllers\CommentController::class);

Route::post('like', [App\Http\Controllers\LikeDislikeController::class, 'like'])->name('like');
