<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MkConexoesAcct.
 *
 * @package namespace App\Entities;
 */
class MkConexoesAcct extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'pgsql2';
    protected $table = 'acct.mk_conexoes_acct';
    protected $primaryKey = 'codconexaoacct';
    protected $fillable = [];
}
