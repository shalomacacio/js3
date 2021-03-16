<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MkPessoa.
 *
 * @package namespace App\Entities;
 */
class MkPessoa extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'pgsql';
    protected $table = "public.mk_pessoas";
    protected $primaryKey = 'codpessoa';
    protected $fillable = [];

    public function endereco(){
      return $this->hasMany('App\Entities\MkLogradouro','codlogradouro', 'codlogradouro' );
    }

    public function bairro(){
      return $this->hasMany('App\Entities\MkBairro','codbairro', 'codbairro' );
    }

    public function faturas(){
      return $this->hasMany('App\Entities\MkFatura','cd_pessoa', 'codpessoa' );
    }

    public function contratos(){
      return $this->hasManyThrough('App\Entities\MkContrato', 'App\Entities\MkOs', 'country_id', 'user_id');
    }

}
