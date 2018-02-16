<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('updateHitNumber', 'AudioController@updateHitNumber');
Route::post('addComment', 'CommentController@addComment');
Route::post('addToFav', 'UserController@addToFav');
Route::post('updateRating', 'AudioController@updateRating');
Route::post('upComment', 'CommentController@upComment');
Route::post('downComment', 'CommentController@downComment');
Route::post('paginateComments', 'AudioController@paginateComments');