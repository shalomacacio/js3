<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkOsItensRepository;
use App\Entities\MkOsItens;
use App\Validators\MkOsItensValidator;

/**
 * Class MkOsItensRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkOsItensRepositoryEloquent extends BaseRepository implements MkOsItensRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkOsItens::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MkOsItensValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
