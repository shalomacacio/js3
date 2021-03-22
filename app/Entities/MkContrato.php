<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MkContrato.
 *
 * @package namespace App\Entities;
 */
class MkContrato extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'pgsql';
    protected $table = "public.mk_contratos";
    protected $primaryKey = 'codcontrato';
    protected $fillable = [];

    public function pessoa(){
      return $this->belongsTo('App\Entities\MkPessoa', 'cliente', 'codpessoa');
    }

    public function planoAcesso(){
      return $this->belongsTo('App\Entities\MkPlanoAcesso', 'plano_acesso', 'codplano');
    }

    public function planoContas(){
      return $this->hasMany('App\Entities\MkPlanoConta', 'codcliente_codfornecedor', 'cliente');
    }

    public function conexao(){
      return $this->hasOne('App\Entities\MkConexao', 'contrato', 'codcontrato');
    }

}
