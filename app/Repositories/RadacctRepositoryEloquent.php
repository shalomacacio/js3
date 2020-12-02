<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RadacctRepository;
use App\Entities\Radacct;
use App\Validators\RadacctValidator;

/**
 * Class RadacctRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RadacctRepositoryEloquent extends BaseRepository implements RadacctRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Radacct::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return RadacctValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
