<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkMovimentacaoBancariaRepository;
use App\Entities\MkMovimentacaoBancaria;
use App\Validators\MkMovimentacaoBancariaValidator;

/**
 * Class MkMovimentacaoBancariaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkMovimentacaoBancariaRepositoryEloquent extends BaseRepository implements MkMovimentacaoBancariaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkMovimentacaoBancaria::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MkMovimentacaoBancariaValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
