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

Route::post("login","\App\Http\Controllers\UserController@login");
Route::post("register","\App\Http\Controllers\UserController@register");

Route::group(["middleware"=>"check.api"],function (){
    Route::post("token","\App\Http\Controllers\ProjectController@token") ;

});

Route::group(['prefix' => 'cloud', 'middleware' => ['auth:api']], function () {
    Route::get('pdfs', 'CloudController@pdfs');
    Route::get('codes/{code}','CloudController@code');
    Route::post('pdfs', 'CloudController@store');
});
