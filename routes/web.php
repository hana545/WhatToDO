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
Route::get('/user/profile', 'UsersController@index')->name('user')->middleware('auth');
Route::post('/user/change_password', 'UsersController@updatePassword')->name('change_password')->middleware('auth');;
Route::post('/user/change_username', 'UsersController@updateUsername')->name('change_username')->middleware('auth');;
Route::get('/user/suspend/{user}', 'UsersController@suspend')->name('suspend_user')->middleware('auth')->middleware('admin');
Route::get('/user/unsuspend/{user}', 'UsersController@unsuspend')->name('unsuspend_user')->middleware('auth')->middleware('admin');

//for searching
Route::get('/search', 'SearchController@index')->name('search');
Route::post('/search', 'SearchController@search')->name('search_objects');
Route::get('/getgeo', 'SearchController@getCoordinates');

///for tags
Route::get('/tag/create', 'HomeController@createTag')->name('add_tag')->middleware('auth')->middleware('admin');
Route::post('/tag/store', 'HomeController@storeTag')->name('store_tag')->middleware('auth')->middleware('admin');
Route::delete('/tag/delete/{tag}', 'HomeController@destroyTag')->name('delete_tag')->middleware('auth')->middleware('admin');
////for category
Route::get('/category/create', 'HomeController@createCategory')->name('add_category')->middleware('auth')->middleware('admin');
Route::post('/category/store', 'HomeController@storeCategory')->name('store_category')->middleware('auth')->middleware('admin');
Route::delete('/category/delete/{category}', 'HomeController@destroyCategory')->name('delete_category')->middleware('auth')->middleware('admin');

//for places/objects
Route::get('/place/create', 'PlacesController@create')->name('add_object')->middleware([ 'auth', 'suspended']);
Route::post('/place/store', 'PlacesController@store')->name('store_object')->middleware([ 'auth', 'suspended']);
Route::get('/place/edit/{place}', 'PlacesController@edit')->name('edit_object')->middleware([ 'auth', 'suspended']);
Route::post('/place/update/{place}', 'PlacesController@update')->name('update_object')->middleware([ 'auth', 'suspended']);
Route::delete('/search/place/delete/{place}', 'PlacesController@destroy_from_search')->name('delete_object_search')->middleware('auth')->middleware('admin');
Route::delete('/user/place/delete/{place}', 'PlacesController@destroy_from_userProfile')->name('delete_object_userProfile')->middleware('auth');;


//for reviews
Route::post('/review/store/{place}', 'ReviewsController@storeReview')->name('store_review')->middleware([ 'auth', 'suspended']);
Route::post('/search/review/update/{review}', 'ReviewsController@updateReview')->name('update_review')->middleware([ 'auth', 'suspended']);
Route::post('/user/review/update/{review}', 'ReviewsController@updateReview_fromUserProfile')->name('updateReview_fromUserProfile')->middleware([ 'auth', 'suspended']);
Route::delete('/user/review/delete/{review}', 'ReviewsController@destroy_fromUserProfile')->name('delete_review_FromUserProfile')->middleware('auth');;
Route::delete('/search/review/delete/{review}', 'ReviewsController@destroy')->name('delete_review')->middleware('auth');;
Route::get('/search/review/delete/{review}', 'ReviewsController@destroy')->name('delete_review')->middleware('auth');;

//locations
Route::post('/location/store', 'LocationsController@store')->name('store_location')->middleware([ 'auth', 'suspended']);
Route::post('/location/update/{location}', 'LocationsController@update')->name('update_location')->middleware([ 'auth', 'suspended']);
Route::delete('/location/delete/{location}', 'LocationsController@destroy')->name('delete_location')->middleware('auth');;

//////admin
//approving
Route::get('/approve', 'PlacesController@approve')->middleware('admin');
Route::get('/approve/{place}', 'PlacesController@approving')->middleware('admin');
Route::delete('/approve/place/delete/{place}', 'PlacesController@destroy_from_approve')->name('delete_object_approve')->middleware('admin');
//users
Route::get('/admin/manage', 'AdminController@manageAdminsUsers')->name('manageAdminsUsers')->middleware('admin');
Route::post('/admin/registerUser', 'AdminController@registerUser')->name('registerNewUser')->middleware('admin');
///

