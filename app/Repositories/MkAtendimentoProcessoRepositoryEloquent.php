<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkAtendimentoProcessoRepository;
use App\Entities\MkAtendimentoProcesso;
use App\Validators\MkAtendimentoProcessoValidator;

/**
 * Class MkAtendimentoProcessoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkAtendimentoProcessoRepositoryEloquent extends BaseRepository implements MkAtendimentoProcessoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkAtendimentoProcesso::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
