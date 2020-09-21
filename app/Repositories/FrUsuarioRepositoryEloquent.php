<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FrUsuarioRepository;
use App\Entities\FrUsuario;
use App\Validators\FrUsuarioValidator;

/**
 * Class FrUsuarioRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FrUsuarioRepositoryEloquent extends BaseRepository implements FrUsuarioRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FrUsuario::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
