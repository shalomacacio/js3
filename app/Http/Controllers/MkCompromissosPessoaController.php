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

      // $result = $this->repository->findWhereBetween('com_inicio', [$inicio, $fim]);
      $result = $this->repository->all();

      return dd($result);


      $mkCompromissos = $result->groupBy('cd_funcionario');

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkCompromissos,
            ]);
        }

        return view('mkCompromissos.agenda', compact('mkCompromissos'));
    }


}
