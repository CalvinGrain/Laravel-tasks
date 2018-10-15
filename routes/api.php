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
Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/', 'TasksController@getTasks');
    Route::post('/tasks', 'TasksController@postTask');
    Route::post('/tasks/{task_id}/comments','TasksController@postComment');
});
