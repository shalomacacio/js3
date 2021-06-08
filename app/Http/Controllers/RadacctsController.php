<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\RadacctCreateRequest;
use App\Http\Requests\RadacctUpdateRequest;
use App\Repositories\RadacctRepository;
use App\Validators\RadacctValidator;

/**
 * Class RadacctsController.
 *
 * @package namespace App\Http\Controllers;
 */
class RadacctsController extends Controller
{
    /**
     * @var RadacctRepository
     */
    protected $repository;

    /**
     * @var RadacctValidator
     */
    protected $validator;

    /**
     * RadacctsController constructor.
     *
     * @param RadacctRepository $repository
     * @param RadacctValidator $validator
     */
    public function __construct(RadacctRepository $repository, RadacctValidator $validator)
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
        // $radaccts = $this->repository->all();
        $radaccts = $this->repository
        ->where('nasportidname', '502-93-POP-ADELIA')->first();
        return $radaccts->conexao->cliente->nome_razaosocial;

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $radaccts,
            ]);
        }

        return view('radaccts.index', compact('radaccts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RadacctCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(RadacctCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $radacct = $this->repository->create($request->all());

            $response = [
                'message' => 'Radacct created.',
                'data'    => $radacct->toArray(),
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
        $radacct = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $radacct,
            ]);
        }

        return view('radaccts.show', compact('radacct'));
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
        $radacct = $this->repository->find($id);

        return view('radaccts.edit', compact('radacct'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RadacctUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(RadacctUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $radacct = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Radacct updated.',
                'data'    => $radacct->toArray(),
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
                'message' => 'Radacct deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Radacct deleted.');
    }
}
