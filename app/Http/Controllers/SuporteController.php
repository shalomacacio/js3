<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Repositories\MkCompromissoRepository;
use App\Repositories\MkAtendimentoRepository;

class SuporteController extends Controller
{
  protected $atendimentoRepository;
  protected $compromissoRepository;

  public function __construct(MkAtendimentoRepository $atendimentoRepository, MkCompromissoRepository $compromissoRepository)
  {
    $this->atendimentoRepository = $atendimentoRepository;
    $this->compromissoRepository = $compromissoRepository;
  }

  public function dashboard(){
    return view('suporte.dashboard');
  }

  public function ajaxDashSuporte(){
    $inicio = Carbon::now()->format('Y-m-d 00:00:00');
    $fim = Carbon::now()->format('Y-m-d 23:59:59');

    $suporte =
    [
      239,531,533,535,537,539,541,543,545,547,550,552,554,556,558,560,
      295,532,534,536,538,540,542,544,546,548,551,553,555,557,559,561
    ]; 

    $result = $this->atendimentoRepository->scopeQuery( function($query) use ($suporte) {
      return $query
            ->leftJoin('mk_bairros as bairro', 'mk_atendimento.bairro', 'bairro.codbairro')
            ->leftJoin('mk_logradouros as logradouro', 'mk_atendimento.logradouro', 'logradouro.codlogradouro')
            ->leftJoin('mk_conexoes as con', 'mk_atendimento.conexao', 'con.codconexao')
            ->whereIn('mk_atendimento.cd_subprocesso', $suporte)
            ->where('mk_atendimento.finalizado','=' , 'N')
            ->select('cd_processo', 'finalizado', 'classificacao_encerramento', 'cd_subprocesso', 'bairro.bairro',
            'logradouro.logradouro','con.nasportidname', 'con.nasipaddress');
    })->all();

    $concN1 = $this->atendimentoRepository->scopeQuery( function($query) use($inicio, $fim) {
      return $query
            ->whereBetween('dt_finaliza', [$inicio, $fim])
            ->where('classificacao_encerramento', 190);
    })->all();

    $bairros  =  $result->countBy('bairro');
    $ruas     =  $result->countBy('logradouro');
    $tipos    =  $result->countBy('cd_processo');
    $tipoOs = [13,86,88,97,109,110,137];

    $resultCompromisso = $this->compromissoRepository->scopeQuery(function($query) use ($inicio, $fim, $tipoOs) {
                return $query
                ->join('mk_compromisso_pessoa', 'mk_compromissos.codcompromisso', '=', 'mk_compromisso_pessoa.codcompromisso')
                ->join('mk_os', 'mk_compromissos.cd_integracao', '=', 'mk_os.codos')
                ->join('mk_os_tipo', 'mk_os.tipo_os', '=', 'mk_os_tipo.codostipo')
                ->whereIn('mk_os.tipo_os', $tipoOs)
                ->whereBetween('com_inicio',[$inicio, $fim])
                ->select('cdpessoa','com_inicio','com_titulo', 'mk_os.tipo_os', 'mk_os.status as status', 'mk_compromissos.codcompromisso', 'mk_compromissos.cd_funcionario','cd_integracao');
              })->all();

    $pendentes = $result->count();
    $agendados = $resultCompromisso->count();
    $tecnicos = $resultCompromisso->countBy('cdpessoa');
    $concluidos = $resultCompromisso->where('status', 3)->count();

    $porTec = $resultCompromisso->map( function($t){
      return $t->only(['cdpessoa', 'status']);
    });
 
    return response()->json([
      'ruas'        => $ruas,
      'tipos'       => $tipos,
      'result'      => $result,
      'bairros'     => $bairros,
      'tecnicos'    => $tecnicos,
      'agendados'   => $agendados,
      'pendentes'   => $pendentes,
      'concluidos'  => $concluidos,
      'concN1'      => $concN1->count(), 
    ]);
  }

}
