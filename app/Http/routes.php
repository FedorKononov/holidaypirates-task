<?php

Route::get('/', 'Job\JobController@index');
Route::get('job', 'Job\JobController@index');
Route::get('job/create', 'Job\JobController@create');
Route::post('job/create', 'Job\JobController@store');


// Authentication routes...
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');

// Moderator routes

Route::get('moderator/job', 'Moderator\Job\JobController@index');

Route::get('moderator/user', 'Moderator\User\UserController@index');
Route::get('moderator/user/{id}/edit', 'Moderator\User\UserController@edit');
Route::post('moderator/user/{id}/edit', 'Moderator\User\UserController@update');

Route::get('moderator/group', 'Moderator\User\GroupController@index');
Route::get('moderator/group/create', 'Moderator\User\GroupController@create');
Route::post('moderator/group/create', 'Moderator\User\GroupController@store');

Route::get('moderator/permission', 'Moderator\User\PermissionController@index');
Route::get('moderator/permission/create', 'Moderator\User\PermissionController@create');
Route::post('moderator/permission/create', 'Moderator\User\PermissionController@store');