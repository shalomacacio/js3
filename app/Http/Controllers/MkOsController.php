<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MkOsCreateRequest;
use App\Http\Requests\MkOsUpdateRequest;
use App\Repositories\MkOsRepository;
use App\Validators\MkOsValidator;

/**
 * Class MkOsController.
 *
 * @package namespace App\Http\Controllers;
 */
class MkOsController extends Controller
{
    /**
     * @var MkOsRepository
     */
    protected $repository;

    /**
     * @var MkOsValidator
     */
    protected $validator;

    /**
     * MkOsController constructor.
     *
     * @param MkOsRepository $repository
     * @param MkOsValidator $validator
     */
    public function __construct(MkOsRepository $repository, MkOsValidator $validator)
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
        $mkOs = $this->repository->first();

        return $mkOs->mobileAtuStatus;

        if (request()->wantsJson()) {
            return response()->json([
                'data' => $mkOs,
            ]);
        }
        return view('mkOs.index', compact('mkOs'));
    }

}
