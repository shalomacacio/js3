<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkOsTipoRepository;
use App\Entities\MkOsTipo;
use App\Validators\MkOsTipoValidator;

/**
 * Class MkOsTipoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkOsTipoRepositoryEloquent extends BaseRepository implements MkOsTipoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkOsTipo::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
