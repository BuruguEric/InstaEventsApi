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
Route::get('category' , 'CategoryController@allCategories');
// list all categories
Route::get('category/{category_id}' , 'CategoryController@showCategory');
// post categories
Route::post('category' , 'CategoryController@createCategories');
// update categories
Route::put('category/{category_id}','CategoryController@updateCategory');
// delete categories
Route::delete('category/{category_id}','CategoryController@deleteCategory');
// list all the events
Route::get('events' , 'EventController@allEvents');
// list single events
Route::get('events/{event_id}' , 'EventController@showEvent');
// create new event
Route::post('events' , 'EventController@createEvent');
// Update an event
Route::put('events/{event_id}' , 'EventController@updateEvent');
// Delete an event
Route::delete('events/{event_id}' , 'EventController@destroyEvent');