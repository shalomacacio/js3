<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\GrupoPessoasRepository;
use App\Entities\GrupoPessoas;
use App\Validators\GrupoPessoasValidator;

/**
 * Class GrupoPessoasRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class GrupoPessoasRepositoryEloquent extends BaseRepository implements GrupoPessoasRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GrupoPessoas::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return GrupoPessoasValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
