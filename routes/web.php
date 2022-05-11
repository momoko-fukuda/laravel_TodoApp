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

// Route:: アクション（'接続先', 'どのコントローラーを動かすか'）;

// TODOアプリにアクセスした際に一番最初に表示されるページを指定
Route::get('/', 'HomeController@index');


Route::get('/home', 'HomeController@index')->name('home');

Route::resource("goals", "GoalController");

Route::resource("goals.todos", "TodoController");

// 作成したTodoを並び替える処理を行うルーティングです。
Route::post('/goals/{goal}/todos/{todo}/sort', 'TodoController@sort');

Auth::routes();


