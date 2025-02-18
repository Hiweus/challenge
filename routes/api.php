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


Route::post('/users', '\App\Http\Controllers\UserController@create');
Route::get('/users', '\App\Http\Controllers\UserController@search');
Route::get('/users/{userId}', '\App\Http\Controllers\UserController@index');


Route::post('/accounts', '\App\Http\Controllers\AccountController@create');
Route::get('/accounts/{accountId}', '\App\Http\Controllers\AccountController@index');


Route::post('/transactions', '\App\Http\Controllers\TransactionController@create');