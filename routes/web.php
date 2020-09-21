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


Route::get('/', function() {
  return view('welcome');
})->name('welcome');

Route::get('/login', 'AuthController@login')->name('login');
Route::post('/auth', 'AuthController@auth')->name('auth');

Route::group(['middleware' => ['auth']], function () {
  Route::get('/logout',       'AuthController@logout')->name('logout');
  Route::get('/mkOs',         'MkOsController@index')->name('mkOs.index');

  Route::get('/agenda',       'MkCompromissosController@agenda')->name('mkCompromissos.agenda');
  Route::get('/agendaStatus', 'MkCompromissosController@agendaStatus')->name('mkCompromissos.agendaStatus');
  // comissoesAutorizar
  Route::get('/comissao-autorizar', 'MkComissaosController@comissoesAutorizar')->name('mkComissaos.comissoesAutorizar');

  Route::group(['prefix' => 'suporte'], function () {

    Route::get('/dashboard',       'SuporteController@dashboard')->name('suporte.dashboard');
    Route::get('/ajaxDashSuporte',       'SuporteController@ajaxDashSuporte')->name('suporte.ajaxDashSuporte');

  });

});
