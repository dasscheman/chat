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

Auth::routes();

Route::get('/', 'ChatsController@index');
Route::get('user', 'ChatsController@fetchCurrentUser');
Route::get('allusers', 'ChatsController@fetchAllUsers');
// Route::get('dilemmas', 'DilemmasController@fetchActiveDilemmas');
// Route::get('dilemma/{dilemmaId}/{userId}', 'DilemmasController@dilemma');
// Route::get('uitkomst', 'DilemmasController@fetchDilemmaUitkomsten');
// Route::post('dilemma', 'DilemmasController@saveStatus');
Route::get('messages', 'ChatsController@fetchMessages');
Route::post('messages', 'ChatsController@sendMessage');

Route::get('private/{id}', 'ChatsController@private');
Route::get('private/messages/{id}', 'ChatsController@fetchPrivateMessages');
Route::post('private/messages', 'ChatsController@sendPrivateMessage');
