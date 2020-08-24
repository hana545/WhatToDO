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
Route::get('/user/profile', 'UsersController@index')->name('user');
Route::post('/user/change_password', 'UsersController@updatePassword')->name('change_password');
Route::post('/user/change_username', 'UsersController@updateUsername')->name('change_username');
Route::get('/user/suspend/{user}', 'UsersController@suspend')->name('suspend_user');
Route::get('/user/unsuspend/{user}', 'UsersController@unsuspend')->name('unsuspend_user');

//for searching
Route::get('/search', 'SearchController@index')->name('search');
Route::post('/search', 'SearchController@search')->name('search_objects');
Route::get('/getgeo', 'SearchController@getCoordinates');

///for tags
Route::get('/tag/create', 'HomeController@createTag')->name('add_tag');
Route::post('/tag/store', 'HomeController@storeTag')->name('store_tag');
Route::delete('/tag/delete/{tag}', 'HomeController@destroyTag')->name('delete_tag');
////for category
Route::get('/category/create', 'HomeController@createCategory')->name('add_category');
Route::post('/category/store', 'HomeController@storeCategory')->name('store_category');
Route::delete('/category/delete/{category}', 'HomeController@destroyCategory')->name('delete_category');

//for places/objects
Route::get('/place/create', 'PlacesController@create')->name('add_object');
Route::post('/place/store', 'PlacesController@store')->name('store_object');
Route::get('/place/edit/{place}', 'PlacesController@edit')->name('edit_object');
Route::post('/place/update/{place}', 'PlacesController@update')->name('update_object');
Route::delete('/search/place/delete/{place}', 'PlacesController@destroy_from_search')->name('delete_object_search');
Route::delete('/user/place/delete/{place}', 'PlacesController@destroy_from_userProfile')->name('delete_object_userProfile');


//for reviews
Route::post('/review/store/{place}', 'ReviewsController@storeReview')->name('store_review');
Route::post('/search/review/update/{review}', 'ReviewsController@updateReview')->name('update_review');
Route::post('/user/review/update/{review}', 'ReviewsController@updateReview_fromUserProfile')->name('updateReview_fromUserProfile');
Route::delete('/user/review/delete/{review}', 'ReviewsController@destroy_fromUserProfile')->name('delete_review_FromUserProfile');
Route::delete('/search/review/delete/{review}', 'ReviewsController@destroy')->name('delete_review');

//locations
Route::post('/location/store', 'LocationsController@store')->name('store_location');
Route::post('/location/update/{location}', 'LocationsController@update')->name('update_location');
Route::delete('/location/delete/{location}', 'LocationsController@destroy')->name('delete_location');

//////admin
//approving
Route::get('/approve', 'PlacesController@approve')->middleware('admin');
Route::get('/approve/{place}', 'PlacesController@approving')->middleware('admin');
Route::delete('/approve/place/delete/{place}', 'PlacesController@destroy_from_approve')->name('delete_object_approve')->middleware('admin');
//users
Route::get('/admin/manage', 'AdminController@manageAdminsUsers')->name('manageAdminsUsers')->middleware('admin');
Route::post('/admin/registerUser', 'AdminController@registerUser')->name('registerNewUser')->middleware('admin');
///

