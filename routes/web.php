<?php

use Illuminate\Support\Facades\Route;

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
    return view('contenido.contenido');
});
Route::get('/categoria',            'CategoriaController@index');
Route::post('/categoria/registrar', 'CategoriaController@store');
Route::put('/categoria/actualizar', 'CategoriaController@update');
Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
Route::put('/categoria/activar',    'CategoriaController@activar');
Route::get('/categoria/selectCategoria','CategoriaController@selectCategoria');

Route::get('/unidad',               'UnidadmedidaController@index');
Route::post('/unidad/registrar',    'UnidadmedidaController@store');
Route::put('/unidad/actualizar',    'UnidadmedidaController@update');
Route::put('/unidad/desactivar',    'UnidadmedidaController@desactivar');
Route::put('/unidad/activar',       'UnidadmedidaController@activar');
Route::get('/unidad/selectUnidad','UnidadmedidaController@selectUnidad');

Route::get('/cliente',               'ClienteController@index');
Route::post('/cliente/registrar',    'ClienteController@store');
Route::put('/cliente/actualizar',    'ClienteController@update');

Route::get('/proveedor',               'ProveedorController@index');
Route::post('/proveedor/registrar',    'ProveedorController@store');
Route::put('/proveedor/actualizar',    'ProveedorController@update');

Route::get('/articulo',               'ArticuloController@index');
Route::post('/articulo/registrar',    'ArticuloController@store');
Route::put('/articulo/actualizar',    'ArticuloController@update');
Route::put('/articulo/desactivar',    'ArticuloController@desactivar');
Route::put('/articulo/activar',       'ArticuloController@activar');

Route::get('/rol',               'RolController@index');
Route::post('/rol/registrar',    'RolController@store');
Route::put('/rol/actualizar',    'RolController@update');
Route::put('/rol/desactivar',    'RolController@desactivar');
Route::put('/rol/activar',       'RolController@activar');
Route::get('/rol/selectRol',     'RolController@selectRol');

Route::get('/user',               'UserController@index');
Route::post('/user/registrar',    'UserController@store');
Route::put('/user/actualizar',    'UserController@update');
Route::put('/user/desactivar',    'UserController@desactivar');
Route::put('/user/activar',       'UserController@activar');



