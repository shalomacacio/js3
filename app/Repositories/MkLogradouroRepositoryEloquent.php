<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkLogradouroRepository;
use App\Entities\MkLogradouro;
use App\Validators\MkLogradouroValidator;

/**
 * Class MkLogradouroRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkLogradouroRepositoryEloquent extends BaseRepository implements MkLogradouroRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkLogradouro::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
