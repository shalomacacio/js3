<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MkWsPerfilCreateRequest;
use App\Http\Requests\MkWsPerfilUpdateRequest;
use App\Repositories\MkWsPerfilRepository;
use App\Validators\MkWsPerfilValidator;

/**
 * Class MkWsPerfilsController.
 *
 * @package namespace App\Http\Controllers;
 */
class MkWsPerfilsController extends Controller
{
    /**
     * @var MkWsPerfilRepository
     */
    protected $repository;

    /**
     * @var MkWsPerfilValidator
     */
    protected $validator;

    /**
     * MkWsPerfilsController constructor.
     *
     * @param MkWsPerfilRepository $repository
     * @param MkWsPerfilValidator $validator
     */
    public function __construct(MkWsPerfilRepository $repository, MkWsPerfilValidator $validator)
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
        $mkWsPerfils = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkWsPerfils,
            ]);
        }

        return view('mkWsPerfils.index', compact('mkWsPerfils'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MkWsPerfilCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MkWsPerfilCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $mkWsPerfil = $this->repository->create($request->all());

            $response = [
                'message' => 'MkWsPerfil created.',
                'data'    => $mkWsPerfil->toArray(),
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
        $mkWsPerfil = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkWsPerfil,
            ]);
        }

        return view('mkWsPerfils.show', compact('mkWsPerfil'));
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
        $mkWsPerfil = $this->repository->find($id);

        return view('mkWsPerfils.edit', compact('mkWsPerfil'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MkWsPerfilUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MkWsPerfilUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $mkWsPerfil = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MkWsPerfil updated.',
                'data'    => $mkWsPerfil->toArray(),
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
                'message' => 'MkWsPerfil deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MkWsPerfil deleted.');
    }
}
