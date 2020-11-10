<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MkPessoaCreateRequest;
use App\Http\Requests\MkPessoaUpdateRequest;
use App\Repositories\MkPessoaRepository;
use App\Validators\MkPessoaValidator;

/**
 * Class MkPessoasController.
 *
 * @package namespace App\Http\Controllers;
 */
class MkPessoasController extends Controller
{
    /**
     * @var MkPessoaRepository
     */
    protected $repository;

    /**
     * @var MkPessoaValidator
     */
    protected $validator;
    protected $inicio;
    protected $fim;

    /**
     * MkPessoasController constructor.
     *
     * @param MkPessoaRepository $repository
     * @param MkPessoaValidator $validator
     */
    public function __construct(MkPessoaRepository $repository, MkPessoaValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->inicio = Carbon::now()->format('Y-m-d 00:00:00');
        $this->fim = Carbon::now()->format('Y-m-d 23:59:59');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $mkPessoas = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkPessoas,
            ]);
        }

        return view('mkPessoas.index', compact('mkPessoas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MkPessoaCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MkPessoaCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $mkPessoa = $this->repository->create($request->all());

            $response = [
                'message' => 'MkPessoa created.',
                'data'    => $mkPessoa->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mkPessoa = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkPessoa,
            ]);
        }

        return view('mkPessoas.show', compact('mkPessoa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mkPessoa = $this->repository->find($id);

        return view('mkPessoas.edit', compact('mkPessoa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MkPessoaUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MkPessoaUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $mkPessoa = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MkPessoa updated.',
                'data'    => $mkPessoa->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'MkPessoa deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MkPessoa deleted.');
    }

    public function clientes( Request $request ){

        $inicio = Carbon::parse($request->dt_inicio)->format('Y-m-d 00:00:00');
        $fim = Carbon::parse($request->dt_fim)->format('Y-m-d 23:59:59');

        $result = DB::connection('pgsql')->table('mk_pessoas as cli')
        ->join('mk_contratos as contrato', 'cli.codpessoa', 'contrato.cliente')
        ->where('contrato.cancelado', "N") //causa das diferenças 
        ->get();

        $clientes = $result;

        return view('relatorios.clientes', compact('clientes', 'inicio', 'fim'));

    }

}
