<?php

namespace App\Http\Controllers;

use App\Entities\MkMovimentacaoBancaria;
use App\Entities\MkMovimentacaoCaixa;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MkMovimentacaoBancariaCreateRequest;
use App\Http\Requests\MkMovimentacaoBancariaUpdateRequest;
use App\Repositories\MkMovimentacaoBancariaRepository;
use App\Validators\MkMovimentacaoBancariaValidator;
use Carbon\Carbon;

/**
 * Class MkMovimentacaoBancariasController.
 *
 * @package namespace App\Http\Controllers;
 */
class MkMovimentacaoBancariasController extends Controller
{
    /**
     * @var MkMovimentacaoBancariaRepository
     */
    protected $repository;

    /**
     * @var MkMovimentacaoBancariaValidator
     */
    protected $validator;

    /**
     * MkMovimentacaoBancariasController constructor.
     *
     * @param MkMovimentacaoBancariaRepository $repository
     * @param MkMovimentacaoBancariaValidator $validator
     */
    public function __construct(MkMovimentacaoBancariaRepository $repository, MkMovimentacaoBancariaValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->inicio = Carbon::now()->format('Y-m-d 00:00:00');
        $this->fim= Carbon::now()->format('Y-m-d 23:59:59');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $mkMovimentacaoBancarias = $this->repository->all();

        if (request()->wantsJson()) {
            return response()->json([
                'data' => $mkMovimentacaoBancarias,
            ]);
        }

        return view('mkMovimentacaoBancarias.index', compact('mkMovimentacaoBancarias'));
    }

    public function dashboard(){
        $inicio = $this->inicio;
        $fim = $this->fim;

        $movimentacoes = MkMovimentacaoBancaria::whereBetween('dh_lcto',[$inicio, $fim])->get();

        return view('mkMovimentacaoBancarias.dashboard', compact('movimentacoes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MkMovimentacaoBancariaCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MkMovimentacaoBancariaCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $mkMovimentacaoBancarium = $this->repository->create($request->all());

            $response = [
                'message' => 'MkMovimentacaoBancaria created.',
                'data'    => $mkMovimentacaoBancarium->toArray(),
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
        $mkMovimentacaoBancarium = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkMovimentacaoBancarium,
            ]);
        }

        return view('mkMovimentacaoBancarias.show', compact('mkMovimentacaoBancarium'));
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
        $mkMovimentacaoBancarium = $this->repository->find($id);

        return view('mkMovimentacaoBancarias.edit', compact('mkMovimentacaoBancarium'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MkMovimentacaoBancariaUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MkMovimentacaoBancariaUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $mkMovimentacaoBancarium = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MkMovimentacaoBancaria updated.',
                'data'    => $mkMovimentacaoBancarium->toArray(),
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
                'message' => 'MkMovimentacaoBancaria deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MkMovimentacaoBancaria deleted.');
    }
}
