<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkPlanoContaRepository;
use App\Entities\MkPlanoConta;
use App\Validators\MkPlanoContaValidator;

/**
 * Class MkPlanoContaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkPlanoContaRepositoryEloquent extends BaseRepository implements MkPlanoContaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkPlanoConta::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MkPlanoContaValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
