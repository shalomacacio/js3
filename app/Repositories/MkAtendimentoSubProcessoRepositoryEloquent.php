<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkAtendimentoSubProcessoRepository;
use App\Entities\MkAtendimentoSubProcesso;
use App\Validators\MkAtendimentoSubProcessoValidator;

/**
 * Class MkAtendimentoSubProcessoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkAtendimentoSubProcessoRepositoryEloquent extends BaseRepository implements MkAtendimentoSubProcessoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkAtendimentoSubProcesso::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
