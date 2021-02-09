<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkCidadeRepository;
use App\Entities\MkCidade;
use App\Validators\MkCidadeValidator;

/**
 * Class MkCidadeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkCidadeRepositoryEloquent extends BaseRepository implements MkCidadeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkCidade::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MkCidadeValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
