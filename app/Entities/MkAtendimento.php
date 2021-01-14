<?php

namespace App\Entities;

use Illuminate\Support\Str;
use App\Entities\MkBairro;
use Illuminate\Database\Eloquent\Model;
use App\Entities\MkAtendimentoSubProcesso;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;



/**
 * Class MkAtendimento.
 *
 * @package namespace App\Entities;
 */
class MkAtendimento extends Model implements Transformable
{
    use TransformableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'pgsql';
    protected $table = "public.mk_atendimento";
    protected $primaryKey = 'codatendimento';
    protected $fillable = [];

    //MUTATOR
    // public function getBairroAttribute($value){
    //   return MkBairro::find($value)->bairro;
    // }

    // public function getLogradouroAttribute($value){
    //   return MkLogradouro::find($value)->logradouro;
    // }

    public function getCdProcessoAttribute($value){
      $subproceso = MkAtendimentoProcesso::find($value)->nome_processo;
      if(Str::containsAll($subproceso, ['(SUP)', 'ROTEADOR'])){
        $subproceso = "ROTEADOR";
      }
      if(Str::containsAll($subproceso, ['(SUP)', 'SEM', 'CONEXÃO'])){
        $subproceso = "S.CONEXÃO";
      }
      if(Str::containsAll($subproceso, ['(SUP)', 'QUEDAS'])){
        $subproceso = "QUEDAS";
      }
      if(Str::containsAll($subproceso, ['(SUP)', 'ROMP', 'CLIENTE'])){
        $subproceso = "ROMPIMENTO";
      }
      if(Str::containsAll($subproceso, ['(SUP)', 'LENTIDÃO'])){
        $subproceso = "LENTIDÃO";
      }
      if(Str::containsAll($subproceso, ['(SUP)', 'REGISTRO', 'LIGAÇÃO'])){
        $subproceso = "REG LIGAÇÃO";
      }
      if(Str::containsAll($subproceso, ['(SUP)', 'OUTROS'])){
        $subproceso = "OUTROS";
      }
      return $subproceso;
    }
    
    public function processo(){
      return $this->belongsTo('App\Entities\MkProcesso', 'cd_processo' , 'codprocesso' );
    }

}
