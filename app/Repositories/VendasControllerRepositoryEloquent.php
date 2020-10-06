<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\VendasControllerRepository;
use App\Entities\VendasController;
use App\Validators\VendasControllerValidator;

/**
 * Class VendasControllerRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class VendasControllerRepositoryEloquent extends BaseRepository implements VendasControllerRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return VendasController::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
