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
    Route::get('teacher', [
        'as' => 'teachers.get',
        'uses' => 'TeacherController@getAll'
    ]);
    Route::apiResources([
        'time_form' => 'TimeFormController',
        'study_form' => 'StudyFormController',
        'payment_form' => 'PaymentFormController',
        'profile' => 'ProfileController',
        'speciality' => 'SpecialityController',
        'study_variant' => 'StudyVariantController',
    ]);
});

Route::namespace('App\\Http\\Controllers\\API\\V1\\Dashboard')->prefix('dashboard')->group(function() {
    Route::get('tag/list', 'TagController@list');

    Route::get('category/list', 'CategoryController@list');

    Route::post('user/{user_id}/role/{role_id}', 'UserController@attachRole');
    Route::delete('user/{user_id}/role/{role_id}', 'UserController@detachRole');
    Route::post('user/search', 'UserController@search');

    Route::post('teacher/{id}/avatar', 'TeacherController@changeAvatar')->middleware('auth:api')->name('teacher.store_avatar');


    Route::apiResources([
        'user' => 'UserController',
        'category' => 'CategoryController',
        'tag' => 'TagController',
        'group' => 'GroupController',
        'role' => 'RoleController',
        'teacher' => 'TeacherController',
        'time_form' => 'TimeFormController',
        'study_variant' => 'StudyVariantController',
    ]);
});
