<?php

namespace App\Entities;

use App\Entities\MkOs;
use App\Entities\MkPessoa;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MkCompromisso.
 *
 * @package namespace App\Entities;
 */
class MkCompromisso extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'pgsql';
    protected $table = "public.mk_compromissos";
    protected $primaryKey = 'codcompromisso';
    protected $fillable = [];

    // MUTATORS
    public function getComTituloAttribute($value)
    {
      $truncated = Str::limit($value, 15);
      return $truncated;
    }
    public function getCdPessoaAttribute($value)
    {
      $funcionario = MkPessoa::where('codpessoa', $value)->first();
      return $funcionario->codpessoa."-".$funcionario->nome_razaosocial;
    }

    public function gettipoOsAttribute($value){
      $result =  MkOs::find($value);
      return $value;
    }

    //RELATIONSHIPS
    public function os()
    {
      return $this->belongsTo('App\Entities\MkOs', 'cd_integracao', 'codos');
    }

}
