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
}
