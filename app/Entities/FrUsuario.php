<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class FrUsuario.
 *
 * @package namespace App\Entities;
 */
class FrUsuario extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'pgsql';
    protected $table = "public.fr_usuario";
    protected $primaryKey = 'usr_codigo';
    protected $fillable = [];

}
