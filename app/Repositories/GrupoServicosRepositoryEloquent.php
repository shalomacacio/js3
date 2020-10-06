<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\GrupoServicosRepository;
use App\Entities\GrupoServicos;
use App\Validators\GrupoServicosValidator;

/**
 * Class GrupoServicosRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class GrupoServicosRepositoryEloquent extends BaseRepository implements GrupoServicosRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GrupoServicos::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return GrupoServicosValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
