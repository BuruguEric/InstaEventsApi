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

// list all categories
Route::get('Category' , 'CategoryController@index');
// list single categories
Route::get('Category' , 'CategoryController@show');
// list all the events
Route::get('Events' , 'EventController@allEvents');
// list single events
Route::get('Events/{event_id}' , 'EventController@showEvent');
// create new event
Route::post('Events' , 'EventController@createEvent');
// Update an event
Route::put('Events' , 'EventController@updateEvent');
// Delete an event
Route::delete('Events' , 'EventController@destroyEvent');