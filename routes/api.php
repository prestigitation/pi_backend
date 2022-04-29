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
    Route::get('/teachers/{slug}', 'TeacherController@findBySlug')->name('teacher.find_by_slug');
    Route::get('/news/{slug}', 'NewsController@findBySlug')->name('news.find_by_slug');

    Route::post('/schedules/filter', 'ScheduleController@filter')->name('schedule.filter');
    Route::post('/schedules/download', 'ScheduleController@downloadSchedule')->name('schedule.download');

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
        'questions' => 'QAController',
        'days' => 'DayController'
    ]);
});

Route::namespace('App\\Http\\Controllers\\API\\V1\\Dashboard')->prefix('dashboard')->group(function() {
    Route::middleware('auth:api')->group(function() {
    /* Роуты без пагинации, т.е на получение всех моделей */
    Route::get('groups/all', 'GroupController@getAll')->middleware('web')->name('groups.get_all');
    Route::get('foreign_teachers/all', 'ForeignTeacherController@getAll')->middleware('web')->name('foreign_teachers.get_all');
    Route::get('study_processes/all', 'StudyProcessController@getAll')->middleware('web')->name('study_processes.get_all');
    Route::get('teachers/all', 'TeacherController@getAllIncludingForeign')->middleware('web')->name('teachers.get_all');
    Route::get('pair_formats/all', 'PairFormatController@getAll')->middleware('web')->name('pair_formats.get_all');
    Route::get('questions/all', 'QAController@getAll')->middleware('can:accessQA')->name('pair_formats.get_all');
    Route::get('audiences/all', 'AudienceController@getAll')->middleware('web')->name('audiences.get_all');
    Route::get('subjects/all', 'SubjectController@getAll')->middleware('web')->name('subjects.get_all');
    Route::get('positions/all', 'PositionController@getAll')->middleware('web')->name('positions.get_all');
    Route::get('types/all', 'TypeController@getAll')->middleware('web')->name('types.get_all');
    Route::get('categories/all', 'CategoryController@getAll')->middleware('web')->name('categories.get_all');
    Route::get('education_levels/all', 'EducationLevelController@getAll')->middleware('web')->name('education_levels.get_all');
    Route::get('header_info', 'DashboardController@getHeaderInfo')->middleware('web')->name('header_info.get');;
    Route::get('schedules/me', 'ScheduleController@getMySchedule')->name('schedules.my_schedule');
    Route::get('schedules/versions', 'ScheduleController@getVersions')->name('schedules.get_versions');
    Route::get('audiences/empty', 'AudienceController@getEmptyAudiences')->name('audiences.get_empty');
    Route::get('time/parity', 'DateController@getParity')->name('times.get_parity');


    /* Специфические роуты */
    Route::post('users/{user_id}/roles/{role_id}', 'UserController@attachRole');
    Route::post('users/search', 'UserController@search');
    Route::post('teachers/{id}/avatar', 'TeacherController@changeAvatar')->middleware('auth:api')->name('teacher.store_avatar');
    Route::post('foreign_teachers/{id}/avatar', 'ForeignTeacherController@changeAvatar')->middleware('auth:api')->name('foreign_teacher.store_avatar');
    Route::post('schedules/snapshot', 'ScheduleController@makeSnapshot')->middleware('can:accessSchedule')->name('schedules.make_snapshot');
    Route::post('audience/{audience_id}/pair_number/{pair_number_id}', 'AudienceController@borrow')->middleware('auth:api')->name('audiences.borrow');

    /* Роуты на удаление */
    Route::delete('users/{user_id}/roles/{role_id}', 'UserController@detachRole');


        Route::apiResources([
            'users' => 'UserController',
            'categories' => 'CategoryController',
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
            'foreign_teachers' => 'ForeignTeacherController',
            'audiences' => 'AudienceController',
            'study_processes' => 'StudyProcessController',
            'subjects' => 'SubjectController',
            'questions' => 'QAController'
        ]);
    });
});
