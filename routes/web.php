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

Route::get('/', function () {
    return view('index');
})->middleware(['auth', 'role:admin']);

Auth::routes();

    Route::group(['prefix' => 'admin', 'namespace' => 'Admin','middleware' => ['web', 'auth', 'role:admin']], function () {
    
        
    ################## City Section #######################
    Route::get('city', "CityController@index");
    Route::post('/city_xhr', "CityController@city_xhr");
    Route::post('/city_detail', "CityController@city_detail");
    Route::post('saveCity','CityController@saveCity');  
    Route::post('removeCity','CityController@removeCity'); 
    
    
    ################## Specialities Section #######################
    Route::get('specialists', "SpecialistsController@index");
    Route::post('/specialists_xhr', "SpecialistsController@specialists_xhr");
    Route::post('saveSpecialist','SpecialistsController@saveSpecialist');
    Route::post('/specialist_detail', "SpecialistsController@specialist_detail");
    Route::post('removeSpecialist','SpecialistsController@removeSpecialist'); 
    Route::get('get-specialist','SpecialistsController@get_specialist'); 
    
    
    ################## Profile Section #######################
    Route::get('profile', "ProfileController@index");
    Route::post('/profile_xhr', "ProfileController@profile_xhr");
    Route::post('save-profile','ProfileController@save_profile');
    Route::get('/profile_detail', "ProfileController@profile_detail");
    Route::post('removeProfile','ProfileController@removeProfile'); 
    
    
    
    ################## App Users Section #######################
    Route::get('app-users', "AppUsersController@index");
    Route::post('/app_users_xhr', "AppUsersController@app_users_xhr");
    Route::post('removeUser','AppUsersController@removeUser');
    
    
    
    ################## Review Section #######################
    Route::get('reviews', "ReviewController@index");
    Route::post('/reviews_xhr', "ReviewController@reviews_xhr");
    Route::post('removeReview','ReviewController@removeReview');
    
    ################## Send Notification Section #######################
    Route::get('notification', "NotificationController@index");    
    Route::post('notification_xhr', "NotificationController@notification_xhr");
    Route::post('send-notification-message', "NotificationController@send_notification_message");
    
    ################## Notification Section #######################
    Route::get('notification-setting', "NotificationController@notification_setting");
    Route::post('save-notification-setting', "NotificationController@save_notification_setting");
    
});


