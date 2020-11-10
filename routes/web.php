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

Route::get('/', 'AuthController@login')->name('login');
Route::post('/auth', 'AuthController@auth')->name('auth');

Route::group(['middleware' => ['auth']], function () {

  Route::get('/welcome', function(){ return view('welcome'); })->name('welcome');

  Route::get('/logout',       'AuthController@logout')->name('logout');
  Route::get('/mkOs',         'MkOsController@index')->name('mkOs.index');

  Route::get('/agenda',       'MkCompromissosController@agenda')->name('mkCompromissos.agenda');
  Route::get('/agendaStatus', 'MkCompromissosController@agendaStatus')->name('mkCompromissos.agendaStatus');

  Route::group(['prefix' => 'suporte'], function () {
    Route::get('/dashboard',       'SuporteController@dashboard')->name('suporte.dashboard');
    Route::get('/ajaxDashSuporte',       'SuporteController@ajaxDashSuporte')->name('suporte.ajaxDashSuporte');
  });

  Route::group(['prefix' => 'relatorios'], function () {
    Route::get('/servicos', 'ServicosController@servicos')->name('relatorio.servicos');
    Route::get('/clientes', 'MkPessoasController@clientes')->name('relatorio.clientes');
    Route::get('/contratos', 'MkContratosController@contratos')->name('relatorio.contratos');
    Route::get('/atendimentos', 'MkAtendimentosController@atendimentos')->name('relatorio.atendimentos');
  });

  Route::group(['prefix' => 'financeiro'], function () {
    Route::get('/cancelamentos', 'FinanceiroRelatoriosController@cancelamentos')->name('cancelamentos');
    Route::get('/contratos', 'FinanceiroController@contratos')->name('contratos');
    Route::get('/ajaxCliente', 'FinanceiroController@ajaxCliente')->name('ajaxCliente');
    Route::get('/autocomplete', 'FinanceiroController@autocomplete')->name('autocomplete');
  });

});
