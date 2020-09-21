<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkAtendimentoRepository;
use App\Entities\MkAtendimento;
use App\Validators\MkAtendimentoValidator;

/**
 * Class MkAtendimentoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkAtendimentoRepositoryEloquent extends BaseRepository implements MkAtendimentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkAtendimento::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
