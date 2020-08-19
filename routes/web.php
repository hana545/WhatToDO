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

//for users
Route::get('/user_profile', 'UsersController@index')->name('user');
Route::post('/change_password', 'UsersController@updatePassword')->name('change_password');
Route::post('/change_username', 'UsersController@updateUsername')->name('change_username');

//for searching
Route::get('/search', 'SearchController@index')->name('search');
Route::post('/search', 'SearchController@search')->name('search_objects');
Route::get('/getgeo', 'SearchController@getCoordinates');

///for category and tags
Route::get('/addTag', 'HomeController@createTag')->name('add_tag');
Route::get('/addCategory', 'HomeController@createCategory')->name('add_category');
Route::post('/storetag', 'HomeController@storeTag')->name('store_tag');
Route::post('/storecategory', 'HomeController@storeCategory')->name('store_category');
Route::get('/deleteTag/{tag}', 'HomeController@destroyTag')->name('delete_tag');
Route::get('/deleteCategory/{category}', 'HomeController@destroyCategory')->name('delete_category');

//for places/objects
Route::get('/addObject', 'PlacesController@create')->name('add_object');
Route::post('/storeobject', 'PlacesController@store')->name('store_object');
Route::get('/deleteObject/{place}', 'PlacesController@destroy')->name('delete_object');
//approving
Route::get('approve', 'PlacesController@approve');
Route::get('approve/{place}', 'PlacesController@approving');

//for reviews
Route::post('/storereview/{place}', 'ReviewsController@storeReview')->name('store_review');
Route::post('/updatereview/{review}', 'ReviewsController@updateReview')->name('update_review');


