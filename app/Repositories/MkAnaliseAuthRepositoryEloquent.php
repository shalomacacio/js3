<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkAnaliseAuthRepository;
use App\Entities\MkAnaliseAuth;
use App\Validators\MkAnaliseAuthValidator;

/**
 * Class MkAnaliseAuthRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkAnaliseAuthRepositoryEloquent extends BaseRepository implements MkAnaliseAuthRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkAnaliseAuth::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MkAnaliseAuthValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
