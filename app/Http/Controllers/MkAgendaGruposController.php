<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MkAgendaGrupoCreateRequest;
use App\Http\Requests\MkAgendaGrupoUpdateRequest;
use App\Repositories\MkAgendaGrupoRepository;
use App\Validators\MkAgendaGrupoValidator;

/**
 * Class MkAgendaGruposController.
 *
 * @package namespace App\Http\Controllers;
 */
class MkAgendaGruposController extends Controller
{
    /**
     * @var MkAgendaGrupoRepository
     */
    protected $repository;

    /**
     * @var MkAgendaGrupoValidator
     */
    protected $validator;

    /**
     * MkAgendaGruposController constructor.
     *
     * @param MkAgendaGrupoRepository $repository
     * @param MkAgendaGrupoValidator $validator
     */
    public function __construct(MkAgendaGrupoRepository $repository, MkAgendaGrupoValidator $validator)
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
        $mkAgendaGrupos = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkAgendaGrupos,
            ]);
        }

        return view('mkAgendaGrupos.index', compact('mkAgendaGrupos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MkAgendaGrupoCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MkAgendaGrupoCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $mkAgendaGrupo = $this->repository->create($request->all());

            $response = [
                'message' => 'MkAgendaGrupo created.',
                'data'    => $mkAgendaGrupo->toArray(),
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
        $mkAgendaGrupo = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkAgendaGrupo,
            ]);
        }

        return view('mkAgendaGrupos.show', compact('mkAgendaGrupo'));
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
        $mkAgendaGrupo = $this->repository->find($id);

        return view('mkAgendaGrupos.edit', compact('mkAgendaGrupo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MkAgendaGrupoUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MkAgendaGrupoUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $mkAgendaGrupo = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MkAgendaGrupo updated.',
                'data'    => $mkAgendaGrupo->toArray(),
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
                'message' => 'MkAgendaGrupo deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MkAgendaGrupo deleted.');
    }
}
