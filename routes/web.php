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

Route::get('/','HomeController@show');
Route::post('/','HomeController@post_ajax');
Route::post('/save','HomeController@save');
Route::post('/update','HomeController@update');

Route::get('/solicitudes/{id}','SolicitudController@show');
Route::post('/solicitudes/{id}','SolicitudController@post_ajax');