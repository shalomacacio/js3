<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\MkOsRepository;
use App\Repositories\MkCompromissoRepository;
use App\Repositories\MkAtendimentoRepository;

class SuporteController extends Controller
{
  protected $atendimentoRepository;


  public function __construct(MkAtendimentoRepository $atendimentoRepository)
  {
      $this->atendimentoRepository = $atendimentoRepository;
  }

  public function dashboard(){
    return view('suporte.dashboard');
  }

  public function ajaxDashSuporte(){

    $inicio = Carbon::now()->format('Y-m-d');
    $fim = Carbon::now()->format('Y-m-d');

    $result = $this->atendimentoRepository->scopeQuery(function($query) use ($inicio, $fim) {
      return $query
      ->whereBetween('data_abertura',[$inicio, $fim]);
    })->all();

      $data = [700,500,400];
      $labels = ['teste', 'teste1', 'teste2'];
      $backgroundColor = ['#f56954', '#00a65a', '#f39c12'];

      $datasets = [
        'data' => $data,
        'backgroundColor' => $backgroundColor,
      ];

      $response = [
        'labels' => [$labels],
        'datasets' => [$datasets],
      ];

      return response()->json([
        'result' => $result
        ]);
  }

}
