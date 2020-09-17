<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkOsRepository;
use App\Entities\MkOs;
use App\Validators\MkOsValidator;

/**
 * Class MkOsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkOsRepositoryEloquent extends BaseRepository implements MkOsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkOs::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MkOsValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
