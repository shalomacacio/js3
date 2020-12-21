<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkEstoqueRepository;
use App\Entities\MkEstoque;
use App\Validators\MkEstoqueValidator;

/**
 * Class MkEstoqueRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkEstoqueRepositoryEloquent extends BaseRepository implements MkEstoqueRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkEstoque::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MkEstoqueValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
