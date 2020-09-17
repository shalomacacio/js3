<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkComissaoRepository;
use App\Entities\MkComissao;
use App\Validators\MkComissaoValidator;

/**
 * Class MkComissaoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkComissaoRepositoryEloquent extends BaseRepository implements MkComissaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkComissao::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MkComissaoValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
