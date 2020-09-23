<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\MkAtendimentoSubProcesso;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Entities\MkBairro;

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
    public function getBairroAttribute($value){
      return MkBairro::find($value)->bairro;
    }

    public function getCdProcessoAttribute($value){
      return $subproceso = MkAtendimentoProcesso::find($value)->nome_processo;
    }

    public function processo(){
      return $this->belongsTo('App\Entities\MkProcesso', 'cd_processo' , 'codprocesso' );
    }

}
