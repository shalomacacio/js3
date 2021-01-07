<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MkConexoesAcctCreateRequest;
use App\Http\Requests\MkConexoesAcctUpdateRequest;
use App\Repositories\MkConexoesAcctRepository;
use App\Validators\MkConexoesAcctValidator;

/**
 * Class MkConexoesAcctsController.
 *
 * @package namespace App\Http\Controllers;
 */
class MkConexoesAcctsController extends Controller
{
    /**
     * @var MkConexoesAcctRepository
     */
    protected $repository;

    /**
     * @var MkConexoesAcctValidator
     */
    protected $validator;

    /**
     * MkConexoesAcctsController constructor.
     *
     * @param MkConexoesAcctRepository $repository
     * @param MkConexoesAcctValidator $validator
     */
    public function __construct(MkConexoesAcctRepository $repository, MkConexoesAcctValidator $validator)
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
        $mkConexoesAccts = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkConexoesAccts,
            ]);
        }

        return view('mkConexoesAccts.index', compact('mkConexoesAccts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MkConexoesAcctCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MkConexoesAcctCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $mkConexoesAcct = $this->repository->create($request->all());

            $response = [
                'message' => 'MkConexoesAcct created.',
                'data'    => $mkConexoesAcct->toArray(),
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
        $mkConexoesAcct = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkConexoesAcct,
            ]);
        }

        return view('mkConexoesAccts.show', compact('mkConexoesAcct'));
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
        $mkConexoesAcct = $this->repository->find($id);

        return view('mkConexoesAccts.edit', compact('mkConexoesAcct'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MkConexoesAcctUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MkConexoesAcctUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $mkConexoesAcct = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MkConexoesAcct updated.',
                'data'    => $mkConexoesAcct->toArray(),
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
                'message' => 'MkConexoesAcct deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MkConexoesAcct deleted.');
    }
}
