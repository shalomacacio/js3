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

    public function agendaStatus( Request $request ){

        $status = ['teste'];

      return response()->json([
        'data' => $status,
      ]);

    }


}
