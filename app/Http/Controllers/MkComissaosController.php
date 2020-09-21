<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\MkOs;
use App\Repositories\MkComissaoRepository;
use App\Repositories\MkOsRepository;
use Carbon\Carbon;

class MkComissaosController extends Controller
{

  protected $repositoryOs;

  public function __construct(MkOsRepository $repositoryOs)
  {
    $this->repositoryOs = $repositoryOs;
  }

  public function comissoesAutorizar(Request $request){

    $inicio = Carbon::now()->format('Y-m-d 00:00:00');
    $fim = Carbon::now()->format('Y-m-d 23:59:59');

    if($request->dt_inicio){
      $inicio = Carbon::parse($request->dt_inicio)->format('Y-m-d 00:00:00');
      $fim = Carbon::parse($request->dt_fim)->format('Y-m-d 23:59:59');
    }

    $result = $this->repositoryOs->scopeQuery(function($query) use ($inicio, $fim) {
      return $query
      ->whereBetween('data_fechamento',[$inicio, $fim]);
    })->all();

    $servicos = $result;

    // return dd($result);
    return view('mkComissaos.autorizar', compact('servicos', 'inicio', 'fim'));
  }

}
