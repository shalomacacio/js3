<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkCompromissoRepository;
use App\Entities\MkCompromisso;
use App\Validators\MkCompromissoValidator;

/**
 * Class MkCompromissoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkCompromissoRepositoryEloquent extends BaseRepository implements MkCompromissoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkCompromisso::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MkCompromissoValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
