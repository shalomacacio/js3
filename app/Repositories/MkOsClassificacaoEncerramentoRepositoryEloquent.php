<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkOsClassificacaoEncerramentoRepository;
use App\Entities\MkOsClassificacaoEncerramento;
use App\Validators\MkOsClassificacaoEncerramentoValidator;

/**
 * Class MkOsClassificacaoEncerramentoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkOsClassificacaoEncerramentoRepositoryEloquent extends BaseRepository implements MkOsClassificacaoEncerramentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkOsClassificacaoEncerramento::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
