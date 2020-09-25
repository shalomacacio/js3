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

    $suporte = [73,224,239,268, 437, 464, 467, 469 , 471, 473, 475, 477,480,482, 511, 513, 515];

    $result = $this->atendimentoRepository->scopeQuery( function($query) use ($suporte) {
      return $query
            ->whereIn('cd_subprocesso', $suporte)
            ->where('finalizado','=' , 'N')
            ->select('cd_processo', 'finalizado', 'cd_subprocesso', 'bairro', 'logradouro');
    })->all();

    $bairros =  $result->countBy('bairro');
    $ruas =    $result->countBy('logradouro');
    $tipos =    $result->countBy('cd_processo');
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

    $testes = $resultCompromisso->groupBy('cdpessoa');


    $tecs = $resultCompromisso->pipe(function ($collection) {

      $porTec = $collection->map( function($t){
        return $t->only(['cdpessoa', 'status']);
      });

      return collect([
        'tecnico' => $porTec,
        // 'total' => $collection->count(),
        // 'concluidos' => $collection->where('status',3)->count('cdpessoa'),
      ]);
    });


    return response()->json([
      'pendentes'   => $pendentes,
      'agendados'   => $agendados,
      'concluidos'  => $concluidos,
      'bairros'     => $bairros,
      'tecnicos'    => $tecnicos,
      'tipos'       => $tipos,
      'ruas'        => $ruas,
      'tecs'        => $tecs,
    ]);
  }

}
