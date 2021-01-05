<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\GrupoPessoasCreateRequest;
use App\Http\Requests\GrupoPessoasUpdateRequest;
use App\Repositories\GrupoPessoasRepository;
use App\Validators\GrupoPessoasValidator;

/**
 * Class GrupoPessoasController.
 *
 * @package namespace App\Http\Controllers;
 */
class GrupoPessoasController extends Controller
{
    /**
     * @var GrupoPessoasRepository
     */
    protected $repository;

    /**
     * @var GrupoPessoasValidator
     */
    protected $validator;

    /**
     * GrupoPessoasController constructor.
     *
     * @param GrupoPessoasRepository $repository
     * @param GrupoPessoasValidator $validator
     */
    public function __construct(GrupoPessoasRepository $repository, GrupoPessoasValidator $validator)
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
        $grupoPessoas = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $grupoPessoas,
            ]);
        }

        return view('grupoPessoas.index', compact('grupoPessoas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  GrupoPessoasCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(GrupoPessoasCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $grupoPessoa = $this->repository->create($request->all());

            $response = [
                'message' => 'GrupoPessoas created.',
                'data'    => $grupoPessoa->toArray(),
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
        $grupoPessoa = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $grupoPessoa,
            ]);
        }

        return view('grupoPessoas.show', compact('grupoPessoa'));
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
        $grupoPessoa = $this->repository->find($id);

        return view('grupoPessoas.edit', compact('grupoPessoa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  GrupoPessoasUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(GrupoPessoasUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $grupoPessoa = $this->repository->update($request->all(), $id);
            $response = [
                'message' => 'GrupoPessoas updated.',
                'data'    => $grupoPessoa->toArray(),
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
                'message' => 'GrupoPessoas deleted.',
                'deleted' => $deleted,
            ]);
        }
        return redirect()->back()->with('message', 'GrupoPessoas deleted.');
    }
}
