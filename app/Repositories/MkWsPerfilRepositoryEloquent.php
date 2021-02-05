<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkWsPerfilRepository;
use App\Entities\MkWsPerfil;
use App\Validators\MkWsPerfilValidator;

/**
 * Class MkWsPerfilRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkWsPerfilRepositoryEloquent extends BaseRepository implements MkWsPerfilRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkWsPerfil::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MkWsPerfilValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
