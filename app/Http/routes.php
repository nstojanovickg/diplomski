<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('nowsms', 'NowSmsController@index');
Route::group(['middleware' => 'auth'], function()
{
	Route::get(		'/', 								'DashboardController@index');
	Route::get(		'dashboard', 						'DashboardController@index');
    
	Route::patch(	'admin/ac_manage', 					'AdminUserController@index');
	Route::get(		'admin/ac_manage/page/{page}', 		'AdminUserController@index');
    Route::resource('admin/ac_manage', 					'AdminUserController');
	
	Route::patch(	'admin/translation', 				'TranslationController@index');
	Route::get(		'admin/translation/page/{page}',	'TranslationController@index');
    Route::resource('admin/translation', 				'TranslationController');
	
	Route::get(		'admin/locale/{language}', 			'AdminUserController@setLocale');
	
	Route::patch(	'application/application', 			'ApplicationController@index');
	Route::get(		'application/application/page/{page}','ApplicationController@index');
    Route::resource('application/application', 			'ApplicationController');
	
	Route::patch(	'engagement/engagement', 			'EngagementController@index');
	Route::get(		'engagement/engagement/page/{page}','EngagementController@index');
    Route::resource('engagement/engagement', 			'EngagementController');
	Route::get(		'engagement/engagement/{subject_id}/{course_id}/{school_year_id}/edit','EngagementController@edit');
	Route::patch(	'engagement/engagement/{subject_id}/{course_id}/{school_year_id}','EngagementController@update');
	Route::delete(	'engagement/engagement/{subject_id}/{course_id}/{school_year_id}','EngagementController@destroy');
	
	Route::patch(	'basic/subject', 					'SubjectController@index');
	Route::get(		'basic/subject/page/{page}',		'SubjectController@index');
    Route::resource('basic/subject', 					'SubjectController');
	
	Route::patch(	'basic/period', 					'PeriodController@index');
	Route::get(		'basic/period/page/{page}',			'PeriodController@index');
    Route::resource('basic/period', 					'PeriodController');
	Route::get(		'basic/period/{period_id}/{school_year_id}/edit','PeriodController@edit');
	Route::patch(	'basic/period/{period_id}/{school_year_id}','PeriodController@update');
	Route::delete(	'basic/period/{period_id}/{school_year_id}','PeriodController@destroy');
	
	Route::patch(	'basic/course', 					'CourseController@index');
	Route::get(		'basic/course/page/{page}',			'CourseController@index');
    Route::resource('basic/course', 					'CourseController');
	
	Route::patch(	'basic/student', 					'StudentController@index');
	Route::get(		'basic/student/page/{page}',		'StudentController@index');
    Route::resource('basic/student', 					'StudentController');
	
	Route::patch(	'basic/professor', 					'ProfessorController@index');
	Route::get(		'basic/professor/page/{page}',		'ProfessorController@index');
    Route::resource('basic/professor', 					'ProfessorController');
	
	Route::patch(	'basic/school_year', 				'SchoolYearController@index');
	Route::get(		'basic/school_year/page/{page}',	'SchoolYearController@index');
    Route::resource('basic/school_year', 				'SchoolYearController');
	
	Route::patch(	'basic/study_program', 				'StudyProgramController@index');
	Route::get(		'basic/study_program/page/{page}',	'StudyProgramController@index');
    Route::resource('basic/study_program', 				'StudyProgramController');
	Route::get(		'basic/study_program/{subject_id}/{course_id}/edit','StudyProgramController@edit');
	Route::patch(	'basic/study_program/{subject_id}/{course_id}','StudyProgramController@update');
	Route::delete(	'basic/study_program/{subject_id}/{course_id}','StudyProgramController@destroy');
	
	Route::patch(	'additional_info/application_request', 				'ApplicationRequestController@index');
	Route::get(		'additional_info/application_request/page/{page}',	'ApplicationRequestController@index');
    Route::resource('additional_info/application_request', 				'ApplicationRequestController');
	
	Route::patch(	'additional_info/application_by_subject', 				'ApplicationBySubjectController@index');
	Route::get(		'additional_info/application_by_subject/page/{page}',	'ApplicationBySubjectController@index');
    Route::resource('additional_info/application_by_subject', 				'ApplicationBySubjectController');
	Route::post(	'additional_info/application_by_subject/{subject_id}/{school_year_id}/{course_id}', 'ApplicationBySubjectController@getApplications');
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
