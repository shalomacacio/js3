<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MkPlanoContaCreateRequest;
use App\Http\Requests\MkPlanoContaUpdateRequest;
use App\Repositories\MkPlanoContaRepository;
use App\Validators\MkPlanoContaValidator;

/**
 * Class MkPlanoContasController.
 *
 * @package namespace App\Http\Controllers;
 */
class MkPlanoContasController extends Controller
{
    /**
     * @var MkPlanoContaRepository
     */
    protected $repository;

    /**
     * @var MkPlanoContaValidator
     */
    protected $validator;

    /**
     * MkPlanoContasController constructor.
     *
     * @param MkPlanoContaRepository $repository
     * @param MkPlanoContaValidator $validator
     */
    public function __construct(MkPlanoContaRepository $repository, MkPlanoContaValidator $validator)
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
        $mkPlanoContas = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkPlanoContas,
            ]);
        }

        return view('mkPlanoContas.index', compact('mkPlanoContas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MkPlanoContaCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MkPlanoContaCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $mkPlanoContum = $this->repository->create($request->all());

            $response = [
                'message' => 'MkPlanoConta created.',
                'data'    => $mkPlanoContum->toArray(),
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
        $mkPlanoContum = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkPlanoContum,
            ]);
        }

        return view('mkPlanoContas.show', compact('mkPlanoContum'));
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
        $mkPlanoContum = $this->repository->find($id);

        return view('mkPlanoContas.edit', compact('mkPlanoContum'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MkPlanoContaUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MkPlanoContaUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $mkPlanoContum = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MkPlanoConta updated.',
                'data'    => $mkPlanoContum->toArray(),
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
                'message' => 'MkPlanoConta deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MkPlanoConta deleted.');
    }
}
