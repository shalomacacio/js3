<?php

namespace App\Entities;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Entities\MkOsMobileAtuStatus;

/**
 * Class MkOs.
 *
 * @package namespace App\Entities;
 */
class MkOs extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $connection = 'pgsql';
    protected $table = "public.mk_os";
    protected $primaryKey = 'codos';
    protected $fillable = [];

    public function usuario(){
      return $this->belongsTo('App\Entities\MkPessoa', 'cliente', 'codpessoa');
    }
    public function conexao(){
      return $this->belongsTo('App\Entities\MkConexao', 'conexao_associada', 'codconexao');
    }
    public function contrato(){
      return $this->belongsTo('App\Entities\MkContrato', 'cd_contrato', 'codcontrato');
    }
    public function consultor(){
      return $this->belongsTo('App\Entities\FrUsuario', 'tecnico_responsavel', 'usr_codigo');
    }
    public function tecnico(){
      return $this->belongsTo('App\Entities\FrUsuario', 'operador_fech_tecnico', 'usr_codigo');
    }
    public function osTipo(){
      return $this->belongsTo('App\Entities\MkOsTipo', 'tipo_os', 'codostipo');
    }
    public function classEncerramento(){
      return $this->belongsTo('App\Entities\MkOsClassificacaoEncerramento', 'classificacao_encerramento', 'codclassifenc');
    }
    
    public function logradouro(){
      return $this->belongsTo('App\Entities\MkLogradouro', 'cd_logradouro', 'codlogradouro');
    }
    public function mobileAtuStatus($value){
      $response =  MkOsMobileAtuStatus::where('cd_os', $value)
              ->whereNotNull('tx_extra')
              ->value('tx_extra');
      return $response;
    }
    //HasMany
    public function itens(){
      return $this->hasMany('App\Entities\MkOsItens', 'cd_integracao', 'codos');
    }

    // MUTATORS
    public function getUltimoStatusAppMkTxAttribute($value)
    {
      if(Str::containsAll($value, ['Encerrando'])){
        $value = "ENCERR";
      }
      if(Str::containsAll($value, ['Iniciando'])){
        $value = "INIC";
      }
      if(Str::containsAll($value, ['Deslocamento', 'cancelado'])){
        $value = "DESL.CANC";
      }
      if(Str::containsAll($value, ['Atividade ', 'encerrada', 'sem'])){
        $value = "S.SOLUC";
      }
      return $value;
    }

}
