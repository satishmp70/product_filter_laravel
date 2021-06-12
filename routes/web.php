<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxFilterController;
use App\Http\Controllers\InsatgramAuthController;
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
Route::get('/', 'AjaxController@index');

Route::post('/fetch_data', 'AjaxFilterController@index')->name('fetch_data');


// Route::group(['prefix' => 'admin'], function () {
//     Voyager::routes();
// });


// Route::get('/instagram-get-auth', 'InsatgramAuthController@show')->middleware('auth');
// Route::get('/instagram-auth-response', 'InsatgramAuthController@complete');
