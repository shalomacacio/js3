<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ServicosController extends Controller
{

  protected $inicio;
  protected $fim;

  public function __construct()
  {
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
                ->select('os.data_fechamento', 'os.codos', 'os_tipo.descricao as servico', 'os.tecnico_responsavel', 'os.operador_fech_tecnico', 'os.indicacoes as taxa', 'os.classificacao_encerramento',
                'cliente.nome_razaosocial as cliente',
                'tecnico.usr_nome as tecnico',
                'consultor.usr_nome as consultor',
                'classificacao.classificacao'
                )
              ->get();

    $servicos = $result->sortBy('data_fechamento');

    if (request()->wantsJson()) {
      return response()->json([
        'servicos'   => $servicos
      ]);
    }
    return view('relatorios.servicos', compact('servicos','inicio', 'fim'));
  }
}
