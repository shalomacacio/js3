<?php

namespace App\Http\Controllers;

use App\Entities\MkOsTipo;
use App\Entities\FrUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Entities\MkAtendimentoProcesso;
use App\Entities\MkAtendimentoSubProcesso;
use App\Entities\MkOsClassificacaoEncerramento;

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

    $tecnicos = DB::connection('pgsql')->table('fr_usuario')
    ->where('setor_associado', 'TEC')
    // ->where('cd_perfil_acesso', 6)
    ->whereNull('usr_inicio_expiracao')
    ->select('usr_codigo', 'usr_nome')
    ->get();

    $consultores = FrUsuario::select('usr_codigo')
    // ->where('setor_associado', 'ATE')
    // ->whereNull('usr_inicio_expiracao')
    ->select('usr_codigo', 'usr_nome')
    ->get();

    $tipos = MkOsTipo::all();

    $classificacoes = MkOsClassificacaoEncerramento::all();

    if ($request->has('classificacoes')){
      $classiFiltro = $request->classificacoes;
    } else {
      foreach ($classificacoes as $r) {
        $classiFiltro[] = $r->codclassifenc;
      }
    }

    if($request->has('dt_inicio'))
    {
      $inicio = Carbon::parse($request->dt_inicio)->format('Y-m-d 00:00:00');
      $fim = Carbon::parse($request->dt_fim)->format('Y-m-d 23:59:59');
    }

    $result = DB::connection('pgsql')->table('mk_os as os')
                ->join('mk_pessoas as cliente', 'os.cliente', 'cliente.codpessoa')
                ->leftJoin('mk_os_tipo as os_tipo', 'os.tipo_os', 'os_tipo.codostipo')
                ->leftJoin('mk_contratos as contrato', 'os.cd_contrato', 'contrato.codcontrato')
                ->leftJoin('mk_os_classificacao_encerramento  as classificacao', 'os.classificacao_encerramento', 'classificacao.codclassifenc')
                ->leftJoin('fr_usuario as tecnico', 'os.operador_fech_tecnico', 'tecnico.usr_codigo')
                ->leftJoin('fr_usuario as consultor', 'os.tecnico_responsavel', 'consultor.usr_codigo')
                ->whereIn('os.classificacao_encerramento', $classiFiltro)
                ->whereBetween('os.data_fechamento', [$inicio, $fim])
                ->select('os.data_abertura','os.data_fechamento', 'os.codos', 'os.tipo_os' , 'os_tipo.descricao as servico', 'os.tecnico_responsavel', 'os.operador_fech_tecnico', 'os.indicacoes as taxa', 'os.classificacao_encerramento',
                'cliente.nome_razaosocial as cliente', 'cliente.inativo',
                'tecnico.usr_nome as tecnico',
                'consultor.usr_nome as consultor',
                'contrato.vlr_renovacao as plano',
                'classificacao.classificacao'
                )->get();
    //FILTROS
    if ($request->has('tecnicos'))
      {
        $tecFiltro = $request->tecnicos;
        $servicos = $result
          ->whereIn('operador_fech_tecnico', $tecFiltro )
          ->sortBy('operador_fech_tecnico')->sortBy('data_fechamento');
      } elseif ( $request->has('consultores')) {
        $consultFiltro = $request->consultores;
        $servicos = $result
          ->whereIn('tecnico_responsavel', $consultFiltro )
          ->sortBy('tecnico_responsavel')->sortBy('data_fechamento');
      } elseif( $request->has('tipos')) {
        $tipoFiltro = $request->tipos;
        $servicos = $result
          ->whereIn('tipo_os', $tipoFiltro )
          ->sortBy('tipo_os')->sortBy('data_fechamento');
      }else{
        $servicos = $result->sortBy('operador_fech_tecnico')->sortBy('data_fechamento');
      }

    if (request()->wantsJson()) {
      return response()->json([
        'servicos'   => $servicos
      ]);
    }
    return view('relatorios.servicos', compact('servicos','tecnicos', 'consultores', 'tipos' , 'classificacoes' , 'inicio', 'fim'));
  }

  // public function atendimentos(Request $request){
  //   $inicio = $this->inicio;
  //   $fim = $this->fim;

  //   if($request->has('dt_inicio'))
  //   {
  //     $inicio = Carbon::parse($request->dt_inicio)->format('Y-m-d 00:00:00');
  //     $fim = Carbon::parse($request->dt_fim)->format('Y-m-d 23:59:59');
  //   }

  //   $result = DB::connection('pgsql')->table('mk_atendimento as atendimento')
  //               ->join('mk_pessoas as pessoa', 'atendimento.cliente_cadastrado', 'pessoa.codpessoa')
  //               ->leftjoin('mk_ate_subprocessos as subprocesso', 'atendimento.cd_subprocesso', 'subprocesso.codsubprocesso')
  //               ->leftJoin('mk_ate_os as ate_os','atendimento.codatendimento', 'ate_os.cd_atendimento' )
  //               ->whereBetween('atendimento.dt_abertura', [$inicio, $fim])
  //               ->select('atendimento.codatendimento','atendimento.dt_abertura', 'ate_os.cd_os', 
  //               'pessoa.nome_razaosocial as cliente', 'atendimento.operador_abertura', 'atendimento.como_foi_contato', 'subprocesso.nome_subprocesso')
  //               ->get();
    
  //   $atendimentos = $result;
  //   $processos = MkAtendimentoProcesso::all();
  //   $subprocessos = MkAtendimentoSubProcesso::all();

  //   return view('relatorios.atendimentos', compact('atendimentos','processos','subprocessos', 'inicio', 'fim'));
  // }

}
