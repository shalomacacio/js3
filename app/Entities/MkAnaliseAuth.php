<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MkAnaliseAuth.
 *
 * @package namespace App\Entities;
 */
class MkAnaliseAuth extends Model implements Transformable
{
    use TransformableTrait;    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'pgsql2';
    protected $table = 'acct.mk_analise_auth';
    protected $primaryKey = 'codid';
    protected $fillable = [];

}
