<?php

use Illuminate\Http\Request;

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
Route::group(['prefix' => 'v1'], function () {
    Route::post('login', 'Api\AuthController@login');
    Route::post('register', 'Api\AuthController@register');
    Route::post('logout', 'Api\AuthController@logout');
});
Route::group(['middleware' => 'auth:api', 'prefix' => 'v1'], function() {
    Route::get('getuser', "Api\AuthController@getUser");

    // Get All City
    Route::get('getcity', "Api\IndexController@getCity");

    // Get All Specialities
    Route::get('getspecialities', "Api\IndexController@getSpecialities");

    // Get Profile List
    Route::get('getprofile', "Api\IndexController@getProfile");

    // Get Profile Detail
    Route::post('getprofiledetail', "Api\IndexController@getProfileDetail");
    
    // Get Review
    Route::get('getreview', "Api\IndexController@getReview");
    
    // POST Review
    Route::post('postReviewRating', "Api\IndexController@postReviewRating");
    
    // Get Rattings of a Profile
    Route::post('getratting', "Api\IndexController@getratting");    
    
    // Book Appointment of a Profile
    Route::post('bookAppointment', "Api\IndexController@bookAppointment");    
    
    // Book mark a Profile
    Route::post('bookmarkProfile', "Api\IndexController@bookmarkProfile");
    
    
});
