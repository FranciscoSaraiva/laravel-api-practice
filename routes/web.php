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


/**
 * Homepage
 */
Route::get('/', function () {
    return view('welcome');
});

/**
 *  API Endpoints
 */
Route::get('videos/search', 'API\v1\VideoController@getVideoOnQuery');
Route::get('videos/youtube/{hash}', 'API\v1\VideoController@getYoutubeInfo');
Route::resource('videos', 'API\v1\VideoController');

