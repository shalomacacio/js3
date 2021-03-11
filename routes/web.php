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
 
  //WebServices
  Route::resource('atendimentos', 'MkAtendimentosController');
  Route::resource('clientes',     'GrupoPessoasController');
  Route::resource('/contratos',   'MkContratosController');
  Route::resource('/analise',     'MkAnaliseAuthsController');

  Route::get('/agenda',       'MkCompromissosController@agenda')->name('mkCompromissos.agenda');
  Route::get('/agendaStatus', 'MkCompromissosController@agendaStatus')->name('mkCompromissos.agendaStatus');

  Route::group(['prefix' => 'suporte'], function () {
    Route::get('/dashboard',      'SuporteController@dashboard')->name('suporte.dashboard');
    Route::get('/ajaxDashSuporte','SuporteController@ajaxDashSuporte')->name('suporte.ajaxDashSuporte');
  });

  Route::group(['prefix' => 'relatorios'], function () {
    Route::get('/teste',          'RadacctsController@index')->name('teste');
    Route::get('/servicos',       'RelatorioController@servicos')->name('relatorio.servicos');
    Route::get('/clientes',       'MkPessoasController@clientes')->name('relatorio.clientes');
    Route::get('/contratos',      'RelatorioController@contratos')->name('relatorio.contratos');
    Route::get('/radacct',        'RelatorioController@radacct')->name('relatorio.radacct');
    Route::get('/inadimplencias', 'RelatorioController@inadimplencias')->name('relatorio.inadimplencias');
    Route::get('/contratos_os',   'RelatorioController@contratos_os')->name('relatorio.contratos_os');
    Route::get('/atendimentos',   'MkAtendimentosController@atendimentos')->name('relatorio.atendimentos');
  });

  Route::group(['prefix' => 'estoque'], function () {
    Route::get('/fiscalizar',   'MkEstoquesController@fiscalizar')->name('estoque.fiscalizar');
    Route::get('/ajaxEstoque',  'MkEstoquesController@ajaxEstoque')->name('estoque.ajaxEstoque');
    Route::get('/ajaxCliente',  'MkEstoquesController@ajaxCliente')->name('estoque.ajaxCliente');
  });

  Route::group(['prefix' => 'financeiro'], function () {
    Route::get('/cancelamentos',      'FinanceiroRelatoriosController@cancelamentos')->name('cancelamentos');
    Route::get('/contratos',          'RelatorioController@contratos')->name('contratos');
    Route::get('/ajaxCliente',        'FinanceiroController@ajaxCliente')->name('ajaxCliente');
    Route::get('/autocomplete',       'FinanceiroController@autocomplete')->name('autocomplete');
    Route::get('/dashboard',          'MkMovimentacaoBancariasController@dashboard')->name('fin.dashboard');
    Route::resource('/movimentacao',  'MkMovimentacaoCaixasController');
  
  });

  Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/suporte',      'DashboardController@dash_suporte')->name('dash.suporte');
    Route::get('/ajaxBarChart', 'DashboardController@ajaxBarChart')->name('dash.ajaxBarChart');
  });

  Route::group(['prefix' => 'api'], function () {
    Route::get('/tokenAuth',  'MkApisController@getTokenAuth')->name('tokenAuth');
    Route::get('/dbMigracao', 'MkApisController@dbMigracao')->name('dbMigracao');
    Route::get('/teste',      'MkApisController@teste')->name('teste');
  });

});
