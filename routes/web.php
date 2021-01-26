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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes(['register' => false, 'reset' => false ]);

Route::get('/', [App\Http\Controllers\ChatsController::class, 'index'])->name('home');


//Route::get('/', 'ChatsController@index');
Route::get('user', [App\Http\Controllers\ChatsController::class, 'fetchCurrentUser']);
Route::get('allusers', [App\Http\Controllers\ChatsController::class, 'fetchAllUsers']);

Route::post('dilemma', [App\Http\Controllers\DilemmasController::class, 'isaveUitkomst']);
Route::post('dilemmas', [App\Http\Controllers\DilemmasController::class, 'fetchDilemmas']);

Route::get('messages', [App\Http\Controllers\ChatsController::class, 'fetchMessages']);
Route::post('messages', [App\Http\Controllers\ChatsController::class, 'sendMessage']);

Route::get('private/{id}', [App\Http\Controllers\ChatsController::class, 'private']);
Route::get('private/messages/{id}', [App\Http\Controllers\ChatsController::class, 'fetchPrivateMessages']);
Route::post('private/messages', [App\Http\Controllers\ChatsController::class, 'sendPrivateMessage']);
