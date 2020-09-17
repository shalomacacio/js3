<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkBairroRepository;
use App\Entities\MkBairro;
use App\Validators\MkBairroValidator;

/**
 * Class MkBairroRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkBairroRepositoryEloquent extends BaseRepository implements MkBairroRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkBairro::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
