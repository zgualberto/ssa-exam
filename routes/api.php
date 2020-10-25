<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::prefix('user')->middleware('auth')->group(function () {
    Route::post('', 'UsersController@store')->name('users.create');
    Route::delete('{id}', 'UsersController@destroy')->name('users.trashed');
    Route::delete('force-delete/{id}', 'UsersController@forceDelete')->name('users.delete');
    Route::put('{id}', 'UsersController@update')->name('users.update');
    Route::patch('{id}', 'UsersController@restore')->name('users.restore');
});
