<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SMSRepository;
use App\Entities\SMS;
use App\Validators\SMSValidator;

/**
 * Class SMSRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SMSRepositoryEloquent extends BaseRepository implements SMSRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SMS::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return SMSValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
