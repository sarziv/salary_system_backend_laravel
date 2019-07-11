<?php

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

/**
 *AuthController
 */
Route::group([
    'prefix' => 'auth','throttle:60,1'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group([
        'middleware' => 'auth:api','throttle:60,1'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

/**
 * RecordsControlelr
 */

Route::group([
    'prefix' => 'user'
], function () {
    Route::group([
        'middleware' => 'auth:api','throttle:60,1'
    ], function() {
        Route::get('records', 'RecordsController@index');
        Route::post('statistic', 'RecordsController@currentMonth');
        Route::post('add', 'RecordsController@store');
        Route::post('search', 'RecordsController@search');
        Route::delete('delete/{id}', 'RecordsController@destroy');
    });
});


/**
 * RateController
 * */
Route::group([
    'prefix' => 'rate','throttle:60,1'
    ], function() {
        Route::get('all', 'RateController@index');
    });

/**
 * RecoverController
 */
Route::group([
    'prefix' => 'recover', 'throttle:60,1'
], function () {
    Route::post('password', 'RecoverController@password');
    Route::post('link', 'RecoverController@link');
});