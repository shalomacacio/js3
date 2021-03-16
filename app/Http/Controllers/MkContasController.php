<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MkContaCreateRequest;
use App\Http\Requests\MkContaUpdateRequest;
use App\Repositories\MkContaRepository;
use App\Validators\MkContaValidator;

/**
 * Class MkContasController.
 *
 * @package namespace App\Http\Controllers;
 */
class MkContasController extends Controller
{
    /**
     * @var MkContaRepository
     */
    protected $repository;

    /**
     * @var MkContaValidator
     */
    protected $validator;

    /**
     * MkContasController constructor.
     *
     * @param MkContaRepository $repository
     * @param MkContaValidator $validator
     */
    public function __construct(MkContaRepository $repository, MkContaValidator $validator)
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
        $mkContas = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkContas,
            ]);
        }

        return view('mkContas.index', compact('mkContas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MkContaCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MkContaCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $mkContum = $this->repository->create($request->all());

            $response = [
                'message' => 'MkConta created.',
                'data'    => $mkContum->toArray(),
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
        $mkContum = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkContum,
            ]);
        }

        return view('mkContas.show', compact('mkContum'));
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
        $mkContum = $this->repository->find($id);

        return view('mkContas.edit', compact('mkContum'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MkContaUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MkContaUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $mkContum = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MkConta updated.',
                'data'    => $mkContum->toArray(),
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
                'message' => 'MkConta deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MkConta deleted.');
    }
}
