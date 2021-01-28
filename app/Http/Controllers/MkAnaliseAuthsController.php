<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MkAnaliseAuthCreateRequest;
use App\Http\Requests\MkAnaliseAuthUpdateRequest;
use App\Repositories\MkAnaliseAuthRepository;
use App\Validators\MkAnaliseAuthValidator;

/**
 * Class MkAnaliseAuthsController.
 *
 * @package namespace App\Http\Controllers;
 */
class MkAnaliseAuthsController extends Controller
{
    /**
     * @var MkAnaliseAuthRepository
     */
    protected $repository;

    /**
     * @var MkAnaliseAuthValidator
     */
    protected $validator;

    /**
     * MkAnaliseAuthsController constructor.
     *
     * @param MkAnaliseAuthRepository $repository
     * @param MkAnaliseAuthValidator $validator
     */
    public function __construct(MkAnaliseAuthRepository $repository, MkAnaliseAuthValidator $validator)
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
        $mkAnaliseAuths = $this->repository->all();
        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkAnaliseAuths,
            ]);
        }
        return view('mkAnaliseAuths.index', compact('mkAnaliseAuths'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MkAnaliseAuthCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MkAnaliseAuthCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $mkAnaliseAuth = $this->repository->create($request->all());

            $response = [
                'message' => 'MkAnaliseAuth created.',
                'data'    => $mkAnaliseAuth->toArray(),
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
        $mkAnaliseAuth = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkAnaliseAuth,
            ]);
        }

        return view('mkAnaliseAuths.show', compact('mkAnaliseAuth'));
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
        $mkAnaliseAuth = $this->repository->find($id);

        return view('mkAnaliseAuths.edit', compact('mkAnaliseAuth'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MkAnaliseAuthUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MkAnaliseAuthUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $mkAnaliseAuth = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MkAnaliseAuth updated.',
                'data'    => $mkAnaliseAuth->toArray(),
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
                'message' => 'MkAnaliseAuth deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MkAnaliseAuth deleted.');
    }
}
