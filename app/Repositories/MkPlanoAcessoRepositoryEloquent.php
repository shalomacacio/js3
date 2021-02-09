<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkPlanoAcessoRepository;
use App\Entities\MkPlanoAcesso;
use App\Validators\MkPlanoAcessoValidator;

/**
 * Class MkPlanoAcessoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkPlanoAcessoRepositoryEloquent extends BaseRepository implements MkPlanoAcessoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkPlanoAcesso::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MkPlanoAcessoValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
