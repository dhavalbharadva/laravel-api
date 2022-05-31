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


/** ------------------------------------------
 *  Admin Routes
 *  ------------------------------------------
 */
defined('ADMIN_SLUG') or define('ADMIN_SLUG', 'admin');

Route::group(array('prefix' => ADMIN_SLUG), function() {
    
    Route::get('/', 'Admin\LoginController@getIndex')->middleware('guest.admin')->name(ADMIN_SLUG);
    //Route::get('logout', array('uses' => 'Admin\LoginController@doLogout'));
    //Route::post('login', array('uses' => 'Admin\LoginController@doLogin'));

    Route::get('logout', 'Admin\LoginController@doLogout')->name('logout');
    Route::post('login', 'Admin\LoginController@doLogin')->name('login');
    
    // Password Reset Routes...
    Route::get('password/reset', array('uses'=>'Admin\ForgotPasswordController@showLinkRequestForm', 'as'=>ADMIN_SLUG.'.password.email'));
    Route::post('password/email', array('uses'=>'Admin\ForgotPasswordController@sendResetLinkEmail', 'as'=>ADMIN_SLUG.'.password.email'));
    Route::get('password/reset/{token}', array('uses'=>'Admin\ResetPasswordController@showResetForm', 'as'=>ADMIN_SLUG.'.password.reset'));
    Route::post('password/reset', array('uses'=>'Admin\ResetPasswordController@reset', 'as'=>ADMIN_SLUG.'.password.reset'));

    //after login
    Route::group(array('middleware' => 'auth.admin'), function() {
        
        Route::get('dashboard', 'Admin\DashboardController@index')->name(ADMIN_SLUG.'.dashboard');
        
        #Admin Profile Management
        Route::resource('profile', 'Admin\ProfileController');
        
        #Admin password change
        Route::get('password/change', array('uses' => 'Admin\ProfileController@changePassword', 'as' => ADMIN_SLUG.'.password.change'));
        Route::post('password/change', array('uses' => 'Admin\ProfileController@updatePassword', 'as' => ADMIN_SLUG.'.password.change'));
        
        #User Management
        Route::get('users/UsersData', 'Admin\UserController@getUsersData');
        Route::post('users/changeStatus', 'Admin\UserController@changeUserStatus');
        Route::resource('users', 'Admin\UserController',['names' => 'admin.users']);
        
    });
});

/** ------------------------------------------
 *  Frontend Routes
 *  ------------------------------------------
 */
Route::get('/', 'Frontend\HomeController@index');

#register user
Route::get('register', array('uses'=>'Frontend\UserController@create','as' => 'frontend.users.create'));

#login user
Route::get('login', array('uses'=>'Frontend\LoginController@getLogin','as' => 'frontend.login'));
Route::post('login', array('uses' => 'Frontend\LoginController@doLogin', 'as' => 'frontend.login'));
Route::resource('users', 'Frontend\UserController');

// Password Reset Routes...
Route::get('password/reset', array('uses'=>'Frontend\ForgotPasswordController@showLinkRequestForm', 'as'=>'password.email'));
Route::post('password/email', array('uses'=>'Frontend\ForgotPasswordController@sendResetLinkEmail', 'as'=>'password.email'));
Route::get('password/reset/{token}', array('uses'=>'Frontend\ResetPasswordController@showResetForm', 'as'=>'password.reset'));
Route::post('password/reset', array('uses'=>'Frontend\ResetPasswordController@reset', 'as'=>'password.reset'));

//after login
Route::group(array('middleware' => 'auth.user'), function() {
    
    Route::get('dashboard', 'Frontend\DashboardController@index');

    Route::post('dashboard', 'Frontend\DashboardController@store')->name('dashboard.store');

    #logout user
    Route::get('logout', 'Frontend\LoginController@doLogout');

    Route::get('{slug}', 'Frontend\DashboardController@shortenUrl')->name('shorten.url');
    
});