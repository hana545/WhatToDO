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


Auth::routes();


Route::get('/', 'HomeController@index')->name('home');


Route::get('/user_profile', 'UsersController@index')->name('user');

Route::get('/search', 'SearchController@index')->name('search');
Route::post('/search', 'SearchController@search')->name('search_objects');
Route::get('/getgeo', 'SearchController@getCoordinates');


Route::get('/addTag', 'HomeController@createTag')->name('add_tag');
Route::get('/addCategory', 'HomeController@createCategory')->name('add_category');
Route::post('/storetag', 'HomeController@storeTag')->name('store_tag');
Route::post('/storecategory', 'HomeController@storeCategory')->name('store_category');


Route::get('/addObject', 'PlacesController@create')->name('add_object');
Route::post('/storeobject', 'PlacesController@store')->name('store_object');

Route::get('approve', 'PlacesController@approve');
Route::get('approve/{place}', 'PlacesController@approving');

