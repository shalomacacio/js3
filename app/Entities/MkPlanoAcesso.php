<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MkPlanoAcesso.
 *
 * @package namespace App\Entities;
 */
class MkPlanoAcesso extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'pgsql';
    protected $table = "public.mk_planos_acesso";
    protected $primaryKey = 'codplano';
    protected $fillable = [];

}
