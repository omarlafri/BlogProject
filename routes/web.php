<?php

use Illuminate\Support\Facades\Route;

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



Route::post('/app/create_tag','AdminController@addTag');
Route::get('/app/get_tags','AdminController@getTags');
Route::post('/app/edit_tag','AdminController@editTag');
Route::post('/app/delete_tag','AdminController@deleteTag');
Route::post('/app/upload','AdminController@upload');
Route::post('/app/remove_file','AdminController@removeFile');
Route::post('/app/create_category','AdminController@addCategory');
Route::get('/app/get_categories','AdminController@getCategories');
Route::post('/app/edit_cat','AdminController@editCat');
Route::post('/app/delete_cat','AdminController@deleteCat');
Route::post('/app/create_user','AdminController@addUser');
Route::get('/app/get_users','AdminController@getUsers');
Route::post('/app/edit_user','AdminController@editUser');
Route::post('/app/delete_user','AdminController@deleteUser');
Route::post('/app/login','AdminController@login');

Route::get('logout','AdminController@logout');
Route::any('{slug}','AdminController@index');
Route::get('/','AdminController@index');









