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

/*
Route::middleware('video:token')->group(function (){
    Route::get('videos/search', 'API\v1\VideoController@getVideoOnQuery');
    Route::get('videos/youtube/{hash}', 'API\v1\VideoController@getYoutubeInfo');
    Route::resource('videos', 'API\v1\VideoController');
});*/