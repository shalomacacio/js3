<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkConexoesAcctRepository;
use App\Entities\MkConexoesAcct;
use App\Validators\MkConexoesAcctValidator;

/**
 * Class MkConexoesAcctRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkConexoesAcctRepositoryEloquent extends BaseRepository implements MkConexoesAcctRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkConexoesAcct::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MkConexoesAcctValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
