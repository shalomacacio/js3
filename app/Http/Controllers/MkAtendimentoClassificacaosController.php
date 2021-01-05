<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MkAtendimentoClassificacaoCreateRequest;
use App\Http\Requests\MkAtendimentoClassificacaoUpdateRequest;
use App\Repositories\MkAtendimentoClassificacaoRepository;
use App\Validators\MkAtendimentoClassificacaoValidator;

/**
 * Class MkAtendimentoClassificacaosController.
 *
 * @package namespace App\Http\Controllers;
 */
class MkAtendimentoClassificacaosController extends Controller
{
    /**
     * @var MkAtendimentoClassificacaoRepository
     */
    protected $repository;

    /**
     * @var MkAtendimentoClassificacaoValidator
     */
    protected $validator;

    /**
     * MkAtendimentoClassificacaosController constructor.
     *
     * @param MkAtendimentoClassificacaoRepository $repository
     * @param MkAtendimentoClassificacaoValidator $validator
     */
    public function __construct(MkAtendimentoClassificacaoRepository $repository, MkAtendimentoClassificacaoValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $mkAtendimentoClassificacaos = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkAtendimentoClassificacaos,
            ]);
        }

        return view('mkAtendimentoClassificacaos.index', compact('mkAtendimentoClassificacaos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MkAtendimentoClassificacaoCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MkAtendimentoClassificacaoCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);
            $mkAtendimentoClassificacao = $this->repository->create($request->all());

            $response = [
                'message' => 'MkAtendimentoClassificacao created.',
                'data'    => $mkAtendimentoClassificacao->toArray(),
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
        $mkAtendimentoClassificacao = $this->repository->find($id);

        if (request()->wantsJson()) {
            return response()->json([
                'data' => $mkAtendimentoClassificacao,
            ]);
        }

        return view('mkAtendimentoClassificacaos.show', compact('mkAtendimentoClassificacao'));
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
        $mkAtendimentoClassificacao = $this->repository->find($id);
        return view('mkAtendimentoClassificacaos.edit', compact('mkAtendimentoClassificacao'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MkAtendimentoClassificacaoUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MkAtendimentoClassificacaoUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $mkAtendimentoClassificacao = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MkAtendimentoClassificacao updated.',
                'data'    => $mkAtendimentoClassificacao->toArray(),
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
                'message' => 'MkAtendimentoClassificacao deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MkAtendimentoClassificacao deleted.');
    }
}
