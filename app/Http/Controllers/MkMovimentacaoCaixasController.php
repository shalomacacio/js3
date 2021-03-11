<?php

namespace App\Http\Controllers;

use App\Entities\MkMovimentacaoCaixa;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MkMovimentacaoCaixaCreateRequest;
use App\Http\Requests\MkMovimentacaoCaixaUpdateRequest;
use App\Repositories\MkMovimentacaoCaixaRepository;
use App\Validators\MkMovimentacaoCaixaValidator;
use Illuminate\Support\Carbon;
/**
 * Class MkMovimentacaoCaixasController.
 *
 * @package namespace App\Http\Controllers;
 */
class MkMovimentacaoCaixasController extends Controller
{
    /**
     * @var MkMovimentacaoCaixaRepository
     */
    protected $repository;

    /**
     * @var MkMovimentacaoCaixaValidator
     */
    protected $validator;

    /**
     * MkMovimentacaoCaixasController constructor.
     *
     * @param MkMovimentacaoCaixaRepository $repository
     * @param MkMovimentacaoCaixaValidator $validator
     */
    public function __construct(MkMovimentacaoCaixaRepository $repository, MkMovimentacaoCaixaValidator $validator)
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
        $mkMovimentacaoCaixas = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkMovimentacaoCaixas,
            ]);
        }

        return view('mkMovimentacaoCaixas.index', compact('mkMovimentacaoCaixas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MkMovimentacaoCaixaCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MkMovimentacaoCaixaCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $mkMovimentacaoCaixa = $this->repository->create($request->all());

            $response = [
                'message' => 'MkMovimentacaoCaixa created.',
                'data'    => $mkMovimentacaoCaixa->toArray(),
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
        $mkMovimentacaoCaixa = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkMovimentacaoCaixa,
            ]);
        }

        return view('mkMovimentacaoCaixas.show', compact('mkMovimentacaoCaixa'));
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
        $mkMovimentacaoCaixa = $this->repository->find($id);

        return view('mkMovimentacaoCaixas.edit', compact('mkMovimentacaoCaixa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MkMovimentacaoCaixaUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MkMovimentacaoCaixaUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $mkMovimentacaoCaixa = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MkMovimentacaoCaixa updated.',
                'data'    => $mkMovimentacaoCaixa->toArray(),
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
                'message' => 'MkMovimentacaoCaixa deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MkMovimentacaoCaixa deleted.');
    }
}
