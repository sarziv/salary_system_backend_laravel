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

/*
 *AuthController
 */
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group([
        //TODO PRODUCTION throttle
        'middleware' => 'auth:api',//'throttle:60,1'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

/*
 * RecordsControlelr
 */

Route::group([
    'prefix' => 'user'
], function () {
    Route::group([
        //TODO PRODUCTION throttle
        'middleware' => 'auth:api',//'throttle:60,1'
    ], function() {
        Route::get('records', 'RecordsController@index');
        Route::post('statistic', 'RecordsController@currentMonth');
        Route::post('add', 'RecordsController@store');
        //Route::put('add/{id}', 'RecordsController@update');
        //Route::delete('add/{id}', 'RecordsController@delete');
        //Search records
        Route::get('search', 'RecordsController@index');

    });
});


/*
 * RateController
 * */
Route::group([
    'prefix' => 'rate'
    ], function() {
        Route::get('all', 'RateController@index');
    });