<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\GrupoServicosCreateRequest;
use App\Http\Requests\GrupoServicosUpdateRequest;
use App\Repositories\GrupoServicosRepository;
use App\Validators\GrupoServicosValidator;

/**
 * Class GrupoServicosController.
 *
 * @package namespace App\Http\Controllers;
 */
class GrupoServicosController extends Controller
{
    /**
     * @var GrupoServicosRepository
     */
    protected $repository;

    /**
     * @var GrupoServicosValidator
     */
    protected $validator;

    /**
     * GrupoServicosController constructor.
     *
     * @param GrupoServicosRepository $repository
     * @param GrupoServicosValidator $validator
     */
    public function __construct(GrupoServicosRepository $repository, GrupoServicosValidator $validator)
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
        $grupoServicos = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $grupoServicos,
            ]);
        }

        return view('grupoServicos.index', compact('grupoServicos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  GrupoServicosCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(GrupoServicosCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $grupoServico = $this->repository->create($request->all());

            $response = [
                'message' => 'GrupoServicos created.',
                'data'    => $grupoServico->toArray(),
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
        $grupoServico = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $grupoServico,
            ]);
        }

        return view('grupoServicos.show', compact('grupoServico'));
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
        $grupoServico = $this->repository->find($id);

        return view('grupoServicos.edit', compact('grupoServico'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  GrupoServicosUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(GrupoServicosUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $grupoServico = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'GrupoServicos updated.',
                'data'    => $grupoServico->toArray(),
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
                'message' => 'GrupoServicos deleted.',
                'deleted' => $deleted,
            ]);
        }
        return redirect()->back()->with('message', 'GrupoServicos deleted.');
    }
}
