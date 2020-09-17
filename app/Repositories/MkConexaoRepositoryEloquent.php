<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MkConexaoRepository;
use App\Entities\MkConexao;
use App\Validators\MkConexaoValidator;

/**
 * Class MkConexaoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MkConexaoRepositoryEloquent extends BaseRepository implements MkConexaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MkConexao::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
