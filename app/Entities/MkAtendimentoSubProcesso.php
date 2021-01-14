<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MkAtendimentoSubProcesso.
 *
 * @package namespace App\Entities;
 */
class MkAtendimentoSubProcesso extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'pgsql';
    protected $table = "public.mk_ate_subprocessos";
    protected $primaryKey = 'codsubprocesso';
    protected $fillable = [];
}
