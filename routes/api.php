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


Route::namespace('App\\Http\\Controllers\\API\V1')->group(function () {
    Route::middleware('auth:api')->group(function() {
        Route::apiResources([
            'time_form' => 'TimeFormController',
            'study_form' => 'StudyFormController',
            'payment_form' => 'PaymentFormController',
            'profile' => 'ProfileController',
            'speciality' => 'SpecialityController',
            'study_variant' => 'StudyVariantController',
            'category' => 'CategoryController',
            'direction' => 'DirectionController',
            'news' => 'NewsController',
            'schedule' => 'ScheduleController',
            'teacher' => 'TeacherController'
        ]);
    });
});

Route::namespace('App\\Http\\Controllers\\API\\V1\\Dashboard')->prefix('dashboard')->group(function() {
    Route::middleware('auth:api')->group(function() {
    /* Роуты без пагинации, т.е на получение всех моделей */
    Route::get('group/all', 'GroupController@getAll')->middleware('web')->name('group.get_all');
    Route::get('subject/all', 'SubjectController@getAll')->middleware('web')->name('subject.get_all');
    Route::get('pair/all', 'PairController@getAll')->middleware('web')->name('pair.get_all');
    Route::get('type/all', 'TypeController@getAll')->middleware('web')->name('type.get_all');
    Route::get('education_level/all', 'EducationLevelController@getAll')->middleware('web')->name('education_level.get_all');

    /* Специфические роуты */
    Route::post('user/{user_id}/role/{role_id}', 'UserController@attachRole');
    Route::post('user/search', 'UserController@search');
    Route::post('teacher/{id}/avatar', 'TeacherController@changeAvatar')->middleware('auth:api')->name('teacher.store_avatar');

    /* Роуты на удаление */
    Route::delete('user/{user_id}/role/{role_id}', 'UserController@detachRole');


        Route::apiResources([
            'user' => 'UserController',
            'category' => 'CategoryController',
            'tag' => 'TagController',
            'group' => 'GroupController',
            'role' => 'RoleController',
            'teacher' => 'TeacherController',
            'time_form' => 'TimeFormController',
            'study_variant' => 'StudyVariantController',
            'direction' => 'DirectionController',
            'news' => 'NewsController',
            'schedule' => 'ScheduleController',
            'day' => 'DayController',
            'pair_number' => 'PairNumberController',
            'pair' => 'PairController',
        ]);
    });
});
