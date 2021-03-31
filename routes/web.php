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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', FUNCTION () {
    return view('test');
});

Route::group(['prefix'=>'fanpage'],function()
{
    Route::get('/login','FanpageController@index');
});

Route::get('/fb-callback', 'LoginFacebookController@index');

Route::get('/success', 'LoginFacebookController@success');

Route::get('/logout','LoginFacebookController@logout');

Route::get('/detail_fanpage/{id}','FanpageController@detail_fanpage');

Route::post('/poststatus','FanpageController@poststatus');

Route::get('/edit/{id}','FanpageController@edit');

Route::post('/edit_post','FanpageController@edit_post');

Route::get('/inbox/{id}','InboxController@inbox');

Route::get('/detail_inbox/{id}','InboxController@detail_inbox');

Route::post('/postInbox','InboxController@postInbox');

Route::get('/comments/{id}','CommentController@comment');

Route::get('/detail_comment/{id}','CommentController@detail_comment');

Route::post('/postComment','CommentController@postComment');

Route::post('/delete_comment','CommentController@delete_comment');

Route::get('/status_admin','AdminController@status_admin');

Route::get('/album_admin','AdminController@album_admin');

Route::get('/detail_album/{id}','AdminController@detail_album');
