<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Radacct.
 *
 * @package namespace App\Entities;
 */
class Radacct extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'pgsql2';
    protected $table = "radius.radacct";
    protected $primaryKey = 'radacct_pkey';
    protected $fillable = [];

    public function conexao(){
      return $this->belongsTo('App\Entities\MkConexao', 'username', 'username');
    }

}
