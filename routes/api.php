<?php
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


Route::namespace('App\\Http\\Controllers\\API\V1')->middleware('guest')->group(function () {
    Route::post('/schedules/filter', 'ScheduleController@filter');

    Route::apiResources([
        'time_forms' => 'TimeFormController',
        'study_forms' => 'StudyFormController',
        'payment_forms' => 'PaymentFormController',
        'profiles' => 'ProfileController',
        'specialities' => 'SpecialityController',
        'study_variants' => 'StudyVariantController',
        'categories' => 'CategoryController',
        'directions' => 'DirectionController',
        'news' => 'NewsController',
        'schedules' => 'ScheduleController',
        'teachers' => 'TeacherController',
        'questions' => 'QAController'
    ]);
});

Route::namespace('App\\Http\\Controllers\\API\\V1\\Dashboard')->prefix('dashboard')->group(function() {
    Route::middleware('auth:api')->group(function() {
    /* Роуты без пагинации, т.е на получение всех моделей */
    Route::get('groups/all', 'GroupController@getAll')->middleware('web')->name('group.get_all');
    Route::get('subjects/all', 'SubjectController@getAll')->middleware('web')->name('subject.get_all');
    Route::get('pairs/all', 'PairController@getAll')->middleware('web')->name('pair.get_all');
    Route::get('types/all', 'TypeController@getAll')->middleware('web')->name('type.get_all');
    Route::get('education_levels/all', 'EducationLevelController@getAll')->middleware('web')->name('education_level.get_all');

    /* Специфические роуты */
    Route::post('users/{user_id}/role/{role_id}', 'UserController@attachRole');
    Route::post('users/search', 'UserController@search');
    Route::post('teachers/{id}/avatar', 'TeacherController@changeAvatar')->middleware('auth:api')->name('teacher.store_avatar');

    /* Роуты на удаление */
    Route::delete('users/{user_id}/roles/{role_id}', 'UserController@detachRole');


        Route::apiResources([
            'users' => 'UserController',
            'categories' => 'CategoryController',
            'tags' => 'TagController',
            'groups' => 'GroupController',
            'roles' => 'RoleController',
            'teachers' => 'TeacherController',
            'time_forms' => 'TimeFormController',
            'study_variants' => 'StudyVariantController',
            'directions' => 'DirectionController',
            'news' => 'NewsController',
            'schedules' => 'ScheduleController',
            'days' => 'DayController',
            'pair_numbers' => 'PairNumberController',
            'pairs' => 'PairController',
        ]);
    });
});
