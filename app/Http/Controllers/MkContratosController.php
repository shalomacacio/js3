<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Validators\MkContratoValidator;
use App\Repositories\MkContratoRepository;
use App\Http\Requests\MkContratoCreateRequest;
use App\Http\Requests\MkContratoUpdateRequest;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class MkContratosController.
 *
 * @package namespace App\Http\Controllers;
 */
class MkContratosController extends Controller
{
    /**
     * @var MkContratoRepository
     */
    protected $repository;

    /**
     * @var MkContratoValidator
     */
    protected $validator;

    protected $inicio;

    protected $fim;

    /**
     * MkContratosController constructor.
     *
     * @param MkContratoRepository $repository
     * @param MkContratoValidator $validator
     */
    public function __construct(MkContratoRepository $repository, MkContratoValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->inicio = Carbon::now()->format('d-m-Y 00:00:00');
        $this->fim = Carbon::now()->format('d-m-Y 23:59:59');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $mkContratos = $this->repository->all();
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $mkContratos,
            ]);
        }
        return view('mkContratos.index', compact('mkContratos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MkContratoCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MkContratoCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $mkContrato = $this->repository->create($request->all());

            $response = [
                'message' => 'MkContrato created.',
                'data'    => $mkContrato->toArray(),
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
        $mkContrato = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $mkContrato,
            ]);
        }

        return view('mkContratos.show', compact('mkContrato'));
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
        $mkContrato = $this->repository->find($id);

        return view('mkContratos.edit', compact('mkContrato'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MkContratoUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MkContratoUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $mkContrato = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MkContrato updated.',
                'data'    => $mkContrato->toArray(),
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
                'message' => 'MkContrato deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MkContrato deleted.');
    }

}
