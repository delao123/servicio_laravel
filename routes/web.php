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
Route::post('/','HomeController@peticiones');

Route::post('/faseFinal','HomeController@guardar_datos_sello');
Route::post('/check','HomeController@comparar_existencia');
Route::post('/editFinal','HomeController@guardar_editar');

Route::get('/solicitudes','SolicitudController@show');
Route::post('/solicitudes','SolicitudController@peticiones');


