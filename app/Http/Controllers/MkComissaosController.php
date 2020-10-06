<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Entities\MkOs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\MkComissaoRepository;
use App\Repositories\MkOsRepository;

class MkComissaosController extends Controller
{
  protected $repositoryOs;
  protected $inicio;
  protected $fim;

  public function __construct(MkOsRepository $repositoryOs)
  {
    $this->repositoryOs = $repositoryOs;
    $this->inicio = Carbon::now()->format('Y-m-d 00:00:00');
    $this->fim = Carbon::now()->format('Y-m-d 23:59:59');
  }

  public function servicos(Request $request){

    $inicio = $this->inicio;
    $fim = $this->fim;

    if($request->dt_inicio)
    {
      $inicio = Carbon::parse($request->dt_inicio)->format('Y-m-d 00:00:00');
      $fim = Carbon::parse($request->dt_fim)->format('Y-m-d 23:59:59');
    }

    $result = DB::table('mk_os as os')
                ->join('mk_pessoas as cliente', 'os.cliente', 'cliente.codpessoa')
                ->join('mk_os_tipo as os_tipo', 'os.tipo_os', 'os_tipo.codostipo')
                ->join('mk_os_classificacao_encerramento  as classificacao', 'os.classificacao_encerramento', 'classificacao.codclassifenc')
                ->leftJoin('fr_usuario as tecnico', 'os.operador_fech_tecnico', 'tecnico.usr_codigo')
                ->leftJoin('fr_usuario as consultor', 'os.tecnico_responsavel', 'consultor.usr_codigo')
                ->whereBetween('os.data_fechamento', [$inicio, $fim])
                ->select('os.data_fechamento', 'os.codos', 'os_tipo.descricao', 'os.tecnico_responsavel', 'os.operador_fech_tecnico', 'os.indicacoes', 'os.classificacao_encerramento',
                'cliente.nome_razaosocial',
                'tecnico.usr_nome as tecnico',
                'consultor.usr_nome as consultor',
                'classificacao.classificacao'
                )
                ->get();

    // return dd($result);

    $servicos = $result;

    // return dd($result);
    return view('mkComissaos.autorizar', compact('servicos', 'inicio', 'fim'));
  }

  // public function comissoesAutorizar(Request $request){

  //   $inicio = Carbon::now()->format('Y-m-d 00:00:00');
  //   $fim = Carbon::now()->format('Y-m-d 23:59:59');

  //   if($request->dt_inicio){
  //     $inicio = Carbon::parse($request->dt_inicio)->format('Y-m-d 00:00:00');
  //     $fim = Carbon::parse($request->dt_fim)->format('Y-m-d 23:59:59');
  //   }

  //   $result = $this->repositoryOs->scopeQuery(function($query) use ($inicio, $fim) {
  //     return $query
  //     ->whereBetween('data_fechamento',[$inicio, $fim])
  //     ->select('data_fechamento', 'codos', 'cliente', 'tipo_os');
  //   })->all();

  //   // return dd($result->chunk(100));

  //   $servicos = $result->chunk(100, function($ordens) {
  //     foreach( $ordens as $ordem ){
  //       return $ordem;
  //     }
  //   });

  //   // return dd($result);
  //   return view('mkComissaos.autorizar', compact('servicos', 'inicio', 'fim'));
  // }

}
