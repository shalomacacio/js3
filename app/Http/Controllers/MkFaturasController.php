<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MkFaturaCreateRequest;
use App\Http\Requests\MkFaturaUpdateRequest;
use App\Repositories\MkFaturaRepository;
use App\Validators\MkFaturaValidator;

/**
 * Class MkFaturasController.
 *
 * @package namespace App\Http\Controllers;
 */
class MkFaturasController extends Controller
{
    /**
     * @var MkFaturaRepository
     */
    protected $repository;

    /**
     * @var MkFaturaValidator
     */
    protected $validator;

    /**
     * MkFaturasController constructor.
     *
     * @param MkFaturaRepository $repository
     * @param MkFaturaValidator $validator
     */
    public function __construct(MkFaturaRepository $repository, MkFaturaValidator $validator)
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
        $mkFaturas = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkFaturas,
            ]);
        }

        return view('mkFaturas.index', compact('mkFaturas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MkFaturaCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MkFaturaCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $mkFatura = $this->repository->create($request->all());

            $response = [
                'message' => 'MkFatura created.',
                'data'    => $mkFatura->toArray(),
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
        $mkFatura = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkFatura,
            ]);
        }

        return view('mkFaturas.show', compact('mkFatura'));
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
        $mkFatura = $this->repository->find($id);

        return view('mkFaturas.edit', compact('mkFatura'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MkFaturaUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MkFaturaUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $mkFatura = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MkFatura updated.',
                'data'    => $mkFatura->toArray(),
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
                'message' => 'MkFatura deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MkFatura deleted.');
    }
}
