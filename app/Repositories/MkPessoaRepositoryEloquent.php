<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkPessoaRepository;
use App\Entities\MkPessoa;
use App\Validators\MkPessoaValidator;

/**
 * Class MkPessoaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkPessoaRepositoryEloquent extends BaseRepository implements MkPessoaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkPessoa::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MkPessoaValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
