<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Repositories\MkCompromissoPessoaRepository;


/**
 * Class MkCompromissosController.
 *
 * @package namespace App\Http\Controllers;
 */
class MkCompromissosPessoaController extends Controller
{
    /**
     * @var MkCompromissoPessoaRepository
     */
    protected $repository;

    /**
     * MkCompromissosController constructor.
     *
     * @param MkCompromissoRepository $repository
     */
    public function __construct(MkCompromissoPessoaRepository $repository)
    {
        $this->repository = $repository;
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function agenda()
    {
      $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

      $inicio = Carbon::now()->format('Y-m-d 00:00:00');
      $fim = Carbon::now()->format('Y-m-d 23:59:59');

      $result = $this->repository
                          ->findWhereBetween(
                            'com_inicio', [$inicio, $fim],
                            [
                            'com_titulo','com_realizado','cliente','codcompromisso','cd_funcionario',
                            'cd_integracao','com_cor_de_fundo','com_cor_da_borda','com_cor_do_texto',
                            'cd_operador','dt_hr_abertura','prioridade','equipe_minima','cdagenda_grupo'
                            ]
                          );


      $mkCompromissos = $result->groupBy('cd_funcionario');

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkCompromissos,
            ]);
        }

        return view('mkCompromissos.agenda', compact('mkCompromissos'));
    }


}
