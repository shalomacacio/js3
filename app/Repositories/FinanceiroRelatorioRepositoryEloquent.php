<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FinanceiroRelatorioRepository;
use App\Entities\FinanceiroRelatorio;
use App\Validators\FinanceiroRelatorioValidator;

/**
 * Class FinanceiroRelatorioRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FinanceiroRelatorioRepositoryEloquent extends BaseRepository implements FinanceiroRelatorioRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FinanceiroRelatorio::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return FinanceiroRelatorioValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
