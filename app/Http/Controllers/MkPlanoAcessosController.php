<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MkPlanoAcessoCreateRequest;
use App\Http\Requests\MkPlanoAcessoUpdateRequest;
use App\Repositories\MkPlanoAcessoRepository;
use App\Validators\MkPlanoAcessoValidator;

/**
 * Class MkPlanoAcessosController.
 *
 * @package namespace App\Http\Controllers;
 */
class MkPlanoAcessosController extends Controller
{
    /**
     * @var MkPlanoAcessoRepository
     */
    protected $repository;

    /**
     * @var MkPlanoAcessoValidator
     */
    protected $validator;

    /**
     * MkPlanoAcessosController constructor.
     *
     * @param MkPlanoAcessoRepository $repository
     * @param MkPlanoAcessoValidator $validator
     */
    public function __construct(MkPlanoAcessoRepository $repository, MkPlanoAcessoValidator $validator)
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
        $mkPlanoAcessos = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkPlanoAcessos,
            ]);
        }

        return view('mkPlanoAcessos.index', compact('mkPlanoAcessos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MkPlanoAcessoCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MkPlanoAcessoCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $mkPlanoAcesso = $this->repository->create($request->all());

            $response = [
                'message' => 'MkPlanoAcesso created.',
                'data'    => $mkPlanoAcesso->toArray(),
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
        $mkPlanoAcesso = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkPlanoAcesso,
            ]);
        }

        return view('mkPlanoAcessos.show', compact('mkPlanoAcesso'));
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
        $mkPlanoAcesso = $this->repository->find($id);

        return view('mkPlanoAcessos.edit', compact('mkPlanoAcesso'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MkPlanoAcessoUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MkPlanoAcessoUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $mkPlanoAcesso = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MkPlanoAcesso updated.',
                'data'    => $mkPlanoAcesso->toArray(),
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
                'message' => 'MkPlanoAcesso deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MkPlanoAcesso deleted.');
    }
}
