<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkAgendaGrupoRepository;
use App\Entities\MkAgendaGrupo;
use App\Validators\MkAgendaGrupoValidator;

/**
 * Class MkAgendaGrupoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkAgendaGrupoRepositoryEloquent extends BaseRepository implements MkAgendaGrupoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkAgendaGrupo::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MkAgendaGrupoValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
