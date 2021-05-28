<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\GeogridRepository;
use App\Entities\Geogrid;
use App\Validators\GeogridValidator;

/**
 * Class GeogridRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class GeogridRepositoryEloquent extends BaseRepository implements GeogridRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Geogrid::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return GeogridValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
