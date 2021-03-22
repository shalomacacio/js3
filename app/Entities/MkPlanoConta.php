<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MkPlanoConta.
 *
 * @package namespace App\Entities;
 */
class MkPlanoConta extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'pgsql';
    protected $table = "public.mk_plano_contas";
    protected $primaryKey = 'codconta';
    protected $fillable = [];

}
