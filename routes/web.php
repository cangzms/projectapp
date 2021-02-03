<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

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
Auth::routes();


Route::resource("/projects","\App\Http\Controllers\ProjectController")->middleware("auth");

Route::get('/', "\App\Http\Controllers\HomeController@index")->middleware("auth");

Route::get("{locale}/",function ($locale){


});

require __DIR__.'/auth.php';
