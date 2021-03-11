<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkMovimentacaoCaixaRepository;
use App\Entities\MkMovimentacaoCaixa;
use App\Validators\MkMovimentacaoCaixaValidator;

/**
 * Class MkMovimentacaoCaixaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkMovimentacaoCaixaRepositoryEloquent extends BaseRepository implements MkMovimentacaoCaixaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkMovimentacaoCaixa::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MkMovimentacaoCaixaValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
