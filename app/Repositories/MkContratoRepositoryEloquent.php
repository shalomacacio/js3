<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkContratoRepository;
use App\Entities\MkContrato;
use App\Validators\MkContratoValidator;

/**
 * Class MkContratoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkContratoRepositoryEloquent extends BaseRepository implements MkContratoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkContrato::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
