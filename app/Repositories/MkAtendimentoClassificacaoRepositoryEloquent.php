<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkAtendimentoClassificacaoRepository;
use App\Entities\MkAtendimentoClassificacao;
use App\Validators\MkAtendimentoClassificacaoValidator;

/**
 * Class MkAtendimentoClassificacaoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkAtendimentoClassificacaoRepositoryEloquent extends BaseRepository implements MkAtendimentoClassificacaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkAtendimentoClassificacao::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MkAtendimentoClassificacaoValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
