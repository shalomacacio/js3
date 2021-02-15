<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MkCompromissoCreateRequest;
use App\Http\Requests\MkCompromissoUpdateRequest;
use App\Repositories\MkCompromissoRepository;
use App\Validators\MkCompromissoValidator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Entities\MkAgendaGrupo;


/**
 * Class MkCompromissosController.
 *
 * @package namespace App\Http\Controllers;
 */
class MkCompromissosController extends Controller
{
    /**
     * @var MkCompromissoRepository
     */
    protected $repository;

    /**
     * @var MkCompromissoValidator
     */
    protected $validator;

    /**
     * MkCompromissosController constructor.
     *
     * @param MkCompromissoRepository $repository
     * @param MkCompromissoValidator $validator
     */
    public function __construct(MkCompromissoRepository $repository, MkCompromissoValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function agenda(Request $request)
    {
      $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

      $inicio = Carbon::now()->format('Y-m-d 00:00:00');
      $fim = Carbon::now()->format('Y-m-d 23:59:59');

      if($request->dt_filtro)
      {
        $inicio = Carbon::parse($request->dt_filtro)->format('Y-m-d 00:00:00');
        $fim = Carbon::parse($request->dt_filtro)->format('Y-m-d 23:59:59');
      }

      $result = $this->repository->scopeQuery(function($query) use ($inicio, $fim) {
        return $query
        ->whereBetween('com_inicio',[$inicio, $fim])
        ->join('mk_compromisso_pessoa', 'mk_compromissos.codcompromisso', '=', 'mk_compromisso_pessoa.codcompromisso')
        ->join('mk_pessoas as pessoa', 'mk_compromisso_pessoa.cdpessoa', '=', 'pessoa.codpessoa')
        ->join('mk_pessoas as cliente', 'mk_compromissos.cliente', '=', 'cliente.codpessoa')
        ->join('mk_os', 'mk_compromissos.cd_integracao', '=', 'mk_os.codos')
        ->join('mk_os_tipo', 'mk_os.tipo_os', '=', 'mk_os_tipo.codostipo')
        ->select('pessoa.nome_razaosocial',
          'cliente.nome_razaosocial as cliente','cliente.complementoendereco as complemento',
          'cdpessoa', 'cdagendagrupo' ,'com_inicio','com_titulo','com_fim',
          'mk_os.dt_hr_fechamento_tec',
          'mk_compromissos.codcompromisso', 'mk_compromissos.cd_funcionario','cd_integracao');
      })->all(); 

      $grupos = MkAgendaGrupo::all();
      $compromissos = $result;

      if($request->grupos){
        $compromissos = $result->whereIn( 'cdagendagrupo', $request->grupos);
        $mkCompromissos = $compromissos->groupBy('nome_razaosocial'); 
      }else{
        $mkCompromissos = $result->groupBy('nome_razaosocial'); 
      }
      if (request()->wantsJson()) {
        return response()->json([
          'data' => $mkCompromissos,
        ]);
      }

      $total = $compromissos->count();
      $concluidos = $compromissos->whereNotNull('dt_hr_fechamento_tec')->count();
      return view('mkCompromissos.agenda', compact('mkCompromissos','grupos', 'request', 'total', 'concluidos'));
    }

    // public function agendaStatus(){
    //   $inicio = Carbon::now()->format('Y-m-d 00:00:00');
    //   $fim = Carbon::now()->format('Y-m-d 23:59:59');

    //   $result = $this->repository->scopeQuery(function($query) use ($inicio, $fim) {
    //     return $query
    //     ->whereBetween('com_inicio',[$inicio, $fim])
    //     ->join('mk_compromisso_pessoa', 'mk_compromissos.codcompromisso', '=', 'mk_compromisso_pessoa.codcompromisso')
    //     ->join('mk_os', 'mk_compromissos.cd_integracao', '=', 'mk_os.codos')
    //     ->join('mk_os_tipo', 'mk_os.tipo_os', '=', 'mk_os_tipo.codostipo')
    //     ->select('cdpessoa');
    //   })->all();

    //   $arr = [];
    //     foreach($result as $funcionario)
    //     {
    //       $arr[] = (array) $funcionario;
    //     }

    //     $data = [700,500,400];
    //     $labels = ['teste', 'teste1', 'teste2'];
    //     $backgroundColor = ['#f56954', '#00a65a', '#f39c12'];

    //     $datasets = [
    //       'data' => $data,
    //       'backgroundColor' => $backgroundColor,
    //     ];

    //     $response = [
    //       'labels' => [$labels],
    //       'datasets' => [$datasets],
    //     ];
    //     return response()->json($response);
    // }
    
}
