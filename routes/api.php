<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

Route::get('version', function () {
    return response()->json(['version' => config('app.version')]);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    Log::debug('User:' . serialize($request->user()));
    return $request->user();
});


Route::namespace('App\\Http\\Controllers\\API\V1')->group(function () {
    Route::get('profile', 'ProfileController@profile');
    Route::put('profile', 'ProfileController@updateProfile');
    Route::post('change-password', 'ProfileController@changePassword');
    Route::get('tag/list', 'TagController@list');
    Route::get('category/list', 'CategoryController@list');

    Route::post('user/{user_id}/role/{role_id}', 'UserController@attachRole');
    Route::delete('user/{user_id}/role/{role_id}', 'UserController@detachRole');
    Route::post('user/search', 'UserController@search');

    Route::post('teacher/{id}/avatar', 'TeacherController@changeAvatar')->middleware('auth:api');

    Route::apiResources([
        'user' => 'UserController',
        'category' => 'CategoryController',
        'tag' => 'TagController',
        'group' => 'GroupController',
        'role' => 'RoleController',
        'teacher' => 'TeacherController'
    ]);
});
