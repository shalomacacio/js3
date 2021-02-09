<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MkCidadeCreateRequest;
use App\Http\Requests\MkCidadeUpdateRequest;
use App\Repositories\MkCidadeRepository;
use App\Validators\MkCidadeValidator;

/**
 * Class MkCidadesController.
 *
 * @package namespace App\Http\Controllers;
 */
class MkCidadesController extends Controller
{
    /**
     * @var MkCidadeRepository
     */
    protected $repository;

    /**
     * @var MkCidadeValidator
     */
    protected $validator;

    /**
     * MkCidadesController constructor.
     *
     * @param MkCidadeRepository $repository
     * @param MkCidadeValidator $validator
     */
    public function __construct(MkCidadeRepository $repository, MkCidadeValidator $validator)
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
        $mkCidades = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkCidades,
            ]);
        }

        return view('mkCidades.index', compact('mkCidades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MkCidadeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MkCidadeCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $mkCidade = $this->repository->create($request->all());

            $response = [
                'message' => 'MkCidade created.',
                'data'    => $mkCidade->toArray(),
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
        $mkCidade = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkCidade,
            ]);
        }

        return view('mkCidades.show', compact('mkCidade'));
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
        $mkCidade = $this->repository->find($id);

        return view('mkCidades.edit', compact('mkCidade'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MkCidadeUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MkCidadeUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $mkCidade = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MkCidade updated.',
                'data'    => $mkCidade->toArray(),
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
                'message' => 'MkCidade deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MkCidade deleted.');
    }
}
