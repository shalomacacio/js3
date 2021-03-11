<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkFaturaRepository;
use App\Entities\MkFatura;
use App\Validators\MkFaturaValidator;

/**
 * Class MkFaturaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkFaturaRepositoryEloquent extends BaseRepository implements MkFaturaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkFatura::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MkFaturaValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
