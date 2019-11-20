<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'HomeController@index');
Route::get('/page/{id}', 'HomeController@page');
Route::get('/projects', 'HomeController@projects');
Route::get('/projects/{id}', 'HomeController@in_project');
Route::get('/projects-archive', 'HomeController@projects_archive');
Route::get('/report/{id}', 'HomeController@report');
Route::get('/news', 'HomeController@news');
Route::get('/news/{id}', 'HomeController@in_news');
Route::get('/news-archive', 'HomeController@news_archive');
Route::get('/want-to-help', 'HomeController@helped');
Route::get('/pay', 'HomeController@pay');
Route::get('/transaction-result', 'HomeController@pay_result');
Route::get('/search', 'HomeController@search');
Route::post('/want', 'HomeController@help_post');

Auth::routes();
