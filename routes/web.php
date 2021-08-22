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
Auth::routes();

Route::get('/', 'HomePage@homepage')->name('welcome');

Route::post('login', ['as' =>'login', 'uses' => 'Auth\LoginController@postLogin']);
Route::post('logout_system', ['as' => 'logout_system', 'uses' => 'Auth\LoginController@getLogout']);

Route::group(['middleware' => 'auth'], function () {

Route::get('admin', 'AdminController@home')->name('admin');
Route::get('libros_activos', 'AdminController@libros_activos')->name('libros_activos');
Route::get('new_book', 'AdminController@new_book')->name('new_book');
Route::post('registrar_libro','AdminController@registrar_libro')->name('registrar_libro');
Route::get('ver_ejemplares/{book_id}','AdminController@ver_ejemplares')->name('ver_ejemplares');
Route::get('editar_libro/{book_id}', 'AdminController@editar_libro')->name('editar_libro');
Route::post('actualizar_libro', 'AdminController@actualizar_libro')->name('actualizar_libro');
Route::get('eliminar_libro/{book_id}', 'AdminController@eliminar_libro')->name('eliminar_libro');
Route::get('desactivar_libro/{book_id}', 'AdminController@desactivar_libro')->name('desactivar_libro');
Route::get('libros_inactivos', 'AdminController@libros_inactivos')->name('libros_inactivos');
Route::get('activar_libro/{book_id}', 'AdminController@activar_libro')->name('activar_libro');

Route::get('nuevo_prestamo', 'AdminController@nuevo_prestamo')->name('nuevo_prestamo');
Route::post('aceptar_prestamo','AdminController@aceptar_prestamo')->name('aceptar_prestamo');
Route::get('prestamo_encurso', 'AdminController@prestamo_encurso')->name('prestamo_encurso');
Route::get('finalizar_prestamo/{borrower_id}', 'AdminController@finalizar_prestamo')->name('finalizar_prestamo');
Route::get('prestamo_finalizado', 'AdminController@prestamo_finalizado')->name('prestamo_finalizado');


});

