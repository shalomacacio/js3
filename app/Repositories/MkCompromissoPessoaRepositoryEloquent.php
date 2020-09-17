<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkCompromissoPessoaRepository;
use App\Entities\MkCompromissoPessoa;
use App\Validators\MkCompromissoPessoaValidator;

/**
 * Class MkCompromissoPessoaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkCompromissoPessoaRepositoryEloquent extends BaseRepository implements MkCompromissoPessoaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkCompromissoPessoa::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
