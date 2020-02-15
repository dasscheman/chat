<?php

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

Auth::routes(['register' => false, 'reset' => false ]);

Route::get('/', 'ChatsController@index');
Route::get('user', 'ChatsController@fetchCurrentUser');
Route::get('allusers', 'ChatsController@fetchAllUsers');

Route::post('dilemma', 'DilemmasController@saveUitkomst');
Route::post('dilemmas', 'DilemmasController@fetchDilemmas');

Route::get('messages', 'ChatsController@fetchMessages');
Route::post('messages', 'ChatsController@sendMessage');

Route::get('private/{id}', 'ChatsController@private');
Route::get('private/messages/{id}', 'ChatsController@fetchPrivateMessages');
Route::post('private/messages', 'ChatsController@sendPrivateMessage');
