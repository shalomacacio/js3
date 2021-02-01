<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkApiRepository;
use App\Entities\MkApi;
use App\Validators\MkApiValidator;

/**
 * Class MkApiRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkApiRepositoryEloquent extends BaseRepository implements MkApiRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkApi::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MkApiValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
