<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MkConexao.
 *
 * @package namespace App\Entities;
 */
class MkConexao extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'pgsql';
    protected $table = "public.mk_conexoes";
    protected $primaryKey = 'codconexao';
    protected $fillable = [];

    public function conexaoacct(){
        return $this->belongsTo('App\Entities\MkConexoesAcct', 'username', 'username');
    }
    public function analiseauth(){
        return $this->belongsTo('App\Entities\MkAnaliseAuth', 'username', 'username');
    }

    public function cliente(){
        return $this->belongsTo('App\Entities\MkPessoa', 'codcliente', 'codpessoa');
    }

    public function contratoAtual(){
        return $this->belongsTo('App\Entities\MkContrato', 'contrato', 'codcontrato');
    }

    public function endereco(){
        return $this->belongsTo('App\Entities\MkLogradouro', 'logradouro', 'codlogradouro');
    }

    public function bairroConex(){
        return $this->belongsTo('App\Entities\MkBairro', 'bairro', 'codbairro');
    }

    public function cidadeConex(){
        return $this->belongsTo('App\Entities\MkCidade', 'cidade', 'codcidade');
    }
}
