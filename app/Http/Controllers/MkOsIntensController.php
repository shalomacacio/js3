<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MkOsItensCreateRequest;
use App\Http\Requests\MkOsItensUpdateRequest;
use App\Repositories\MkOsItensRepository;
use App\Validators\MkOsItensValidator;

/**
 * Class MkOsItensController.
 *
 * @package namespace App\Http\Controllers;
 */
class MkOsItensController extends Controller
{
    /**
     * @var MkOsItensRepository
     */
    protected $repository;

    /**
     * @var MkOsItensValidator
     */
    protected $validator;

    /**
     * MkOsItensController constructor.
     *
     * @param MkOsItensRepository $repository
     * @param MkOsItensValidator $validator
     */
    public function __construct(MkOsItensRepository $repository, MkOsItensValidator $validator)
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
        $MkOsItens = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $MkOsItens,
            ]);
        }

        return view('MkOsItens.index', compact('MkOsItens'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MkOsItensCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MkOsItensCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $mkOsInten = $this->repository->create($request->all());

            $response = [
                'message' => 'MkOsItens created.',
                'data'    => $mkOsInten->toArray(),
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
        $mkOsInten = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkOsInten,
            ]);
        }

        return view('MkOsItens.show', compact('mkOsInten'));
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
        $mkOsInten = $this->repository->find($id);

        return view('MkOsItens.edit', compact('mkOsInten'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MkOsItensUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MkOsItensUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $mkOsInten = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MkOsItens updated.',
                'data'    => $mkOsInten->toArray(),
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
                'message' => 'MkOsItens deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MkOsItens deleted.');
    }
}
