<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MkLogradouro.
 *
 * @package namespace App\Entities;
 */
class MkLogradouro extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'pgsql';
    protected $table = "public.mk_logradouros";
    protected $primaryKey = 'codlogradouro';
    protected $fillable = [];

    public function bairro(){
      return $this->belongsTo('App\Entities\MkBairro', 'codbairro', 'codbairro');
    }

}
