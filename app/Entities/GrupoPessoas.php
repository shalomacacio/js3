<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class GrupoPessoas.
 *
 * @package namespace App\Entities;
 */
class GrupoPessoas extends Model implements Transformable
{
    use TransformableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $connection = 'pgsql2';
    protected $table = 'sis_cliente';
    protected $primaryKey = 'id';
    protected $fillable = [];
}
