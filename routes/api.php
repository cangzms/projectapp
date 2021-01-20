<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;

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

//Route::group(["middleware"=>"check.api"],function (){
//    Route::post("token","\App\Http\Controllers\ProjectController@token") ;
//
//});

Route::group(['prefix' => 'cloud', 'middleware' => ['check.api']], function () {
    Route::get('pdfs', [DocumentController::class,"pdfs"]);
    Route::get('codes/{code}',[DocumentController::class,"code"]);
    Route::post('pdfs', [DocumentController::class,"store"]);
});
