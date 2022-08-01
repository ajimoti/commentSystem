<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/comments', 'CommentController@index');
Route::post('/comments', 'CommentController@create');
Route::post('/comments/replies', 'CommentController@createReply');

Route::get('/replies', 'CommentController@index');
Route::post('/replies', 'CommentController@create');
