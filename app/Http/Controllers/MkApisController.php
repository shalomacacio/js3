<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MkApiCreateRequest;
use App\Http\Requests\MkApiUpdateRequest;
use App\Repositories\MkApiRepository;
use App\Validators\MkApiValidator;

/**
 * Class MkApisController.
 *
 * @package namespace App\Http\Controllers;
 */
class MkApisController extends Controller
{
    /**
     * @var MkApiRepository
     */
    protected $repository;

    /**
     * @var MkApiValidator
     */
    protected $validator;

    /**
     * MkApisController constructor.
     *
     * @param MkApiRepository $repository
     * @param MkApiValidator $validator
     */
    public function __construct(MkApiRepository $repository, MkApiValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }
}
