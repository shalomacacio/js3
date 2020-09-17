<?php

namespace App\Entities;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MkOsTipo.
 *
 * @package namespace App\Entities;
 */
class MkOsTipo extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'pgsql';
    protected $table = "public.mk_os_tipo";
    protected $primaryKey = 'codostipo';
    protected $fillable = [];


    public function getDescricaoAttribute($value)
    {
      if(Str::containsAll($value, ['CONFIGURAÇÃO ', 'ROTEADOR'])){
        $value = "ROTEADOR";
      }
      if(Str::containsAll($value, ['ADESÃO ', 'RESIDENCIAL'])){
        $value = "ADESÃO";
      }
      if(Str::containsAll($value, ['Serv.', 'MIGRACAO'])){
        $value = "MIGRACAO";
      }
      if(Str::containsAll($value, ['ROMPIMENTO', 'CLIENTE'])){
        $value = "ROMPIMENTO";
      }
      if(Str::containsAll($value, ['PUXADA', 'CABO'])){
        $value = "PUX CABO";
      }
      if(Str::containsAll($value, ['TRANSFERÊNCIA', 'RECOLHER'])){
        $value = "RECOLHIMENTO";
      }
      if(Str::containsAll($value, ['TRANSFERÊNCIA', 'INSTALAR'])){
        $value = "TRANSF";
      }
      if(Str::containsAll($value, ['REATIVAÇÃO ', 'RESIDENCIAL'])){
        $value = "REATIVAÇÃO";
      }
      if(Str::containsAll($value, ['SEM ', 'CONEXÃO'])){
        $value = "S.CONEXAO";
      }
      if(Str::containsAll($value, ['CANCELAMENTO', 'GPON'])){
        $value = "CANCEL";
      }
      if(Str::containsAll($value, ['Serv', 'COMPENSAÇÃO'])){
        $value = "COMPENSA";
      }
      return $value;
    }


}
