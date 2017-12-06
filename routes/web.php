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

Route::get('/', 'PagesController@root')->name('root');

Auth::routes();

Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);

Route::resource('testpages', 'TestpagesController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);

Route::post('/testpages/testhandle/{id}', 'TestpagesController@testhandle')->name('testpages.testhandle');
Route::resource('questions', 'QuestionsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);

Route::resource('history', 'HistoryController', ['only' => ['index', 'show', 'destroy']]);

Route::get('/testquestions/index/{id}', 'TestquestionsController@index')->name('testquestions.index');
Route::post('/testquestions/edithandle/{id}', 'TestquestionsController@edithandle')->name('testquestions.edithandle');
Route::get('/testquestions/edit/{id}', 'TestquestionsController@edit')->name('testquestions.edit');