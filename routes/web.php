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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/logout','\App\Http\Controllers\Auth\LoginController@logout');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/trabajos/consulta', 'TFCsController@consulta')->name('consulta');
//Route::resource('trabajos','TFCsController');
Route::get('/trabajos/consulta/{ciclo}/{curso}/{fichero}', 'TFCsController@descargar')->name('descargar');
Route::get('/trabajos/eliminar/{id}', 'TFCsController@eliminarTFC')->name('eliminar');

Route::get('/trabajos/depositar', 'TFCsController@depositar')->name('depositar');
Route::post('/trabajos/confirmar', 'TFCsController@confirmar')->name('confirmar');
Route::post('/trabajos/store', 'TFCsController@store')->name('store');


Route::get('/trabajos/evaluar','TFCsController@evaluar')->name('evaluar');
Route::post('/trabajos/evaluar','TFCsController@grabarNota')->name('evaluar');

Route::get('/users/infoUsuario/{clavePrimaria}', '\App\Http\Controllers\Auth\RegisterController@infoUsuario')->name('infoUsuario');
Route::get('/users/consulta/', '\App\Http\Controllers\Auth\RegisterController@consulta')->name('usuarios');
