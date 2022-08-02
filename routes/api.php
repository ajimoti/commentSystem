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

Route::prefix('comments')->group(function () {
    Route::get('/', 'CommentController@index');
    Route::post('/', 'CommentController@create');
    Route::get('{comment}/replies', 'ReplyController@index');
    Route::post('{comment}/replies', 'ReplyController@create');    
});

Route::prefix('replies')->group(function () {
    Route::post('{reply}', 'ReplyController@createSubReply'); 
    Route::get('{reply}', 'ReplyController@getSubReplies'); 
});

