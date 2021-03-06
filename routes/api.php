<?php
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

// accessing the route... except maybe the route for registering ...
Route::group(['namespace' => 'Api', 'prefix' => 'v1', 'middleware' => ['auth:api']], function() {
	// Sections
	Route::apiResource('sections', 'SectionController');

	// Messages
	Route::apiResource('messages', 'MessageController');

	// Topics
	Route::get('/topics/{topic}/thread', 'TopicThreadController@show');
	Route::apiResource('topics', 'TopicController');

	// Avatars
	Route::apiResource('avatars', 'AvatarController');

	// Users
	Route::get('/users/{user}/profile', 'UserProfileController@show');
	Route::patch('/users/{user}/profile', 'UserProfileController@update');

	Route::get('/users/{user}', 'UserController@show');
	Route::patch('/users/{user}', 'UserController@update');
	Route::delete('/users/{user}', 'UserController@destroy');

	//For highlighting message in topic
	Route::post('/messages/{id}/highlight', 'MessageController@postHighlight');

	//For approving topic
	Route::post('/topics/approve/{topic}', 'TopicController@postApprove');

	//For marking bad message
	Route::post('/messages/{id}/mark-bad', 'MessageController@postMarkBadMessage');
});

Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function() {
	Route::post('/users/{user}', 'UserController@store');
});
