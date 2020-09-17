<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkOsMobileAtuStatusRepository;
use App\Entities\MkOsMobileAtuStatus;
use App\Validators\MkOsMobileAtuStatusValidator;

/**
 * Class MkOsMobileAtuStatusRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkOsMobileAtuStatusRepositoryEloquent extends BaseRepository implements MkOsMobileAtuStatusRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkOsMobileAtuStatus::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
