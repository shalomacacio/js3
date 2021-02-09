<?php

namespace App\Entities;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MkOsClassificacaoEncerramento.
 *
 * @package namespace App\Entities;
 */
class MkOsClassificacaoEncerramento extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'pgsql';
    protected $table = "public.mk_os_classificacao_encerramento";
    protected $primaryKey = 'codclassifenc';
    protected $fillable = [];


    // public function getClassificacaoAttribute($value)
    // {
    //   if(Str::containsAll($value, ['(CAN) RECOLHIDO', 'RECOLHIDO', 'TOTAL'])){
    //     $value = "AUT_REC_TOTAL";
    //   }
    //   if(Str::containsAll($value, ['(CAN) RECOLHIDO', 'RECOLHIDO', 'PARCIAL'])){
    //     $value = "REC.PARC";
    //   }
    //   if(Str::containsAll($value, ['(CAN) ', 'NÃO ', 'RECOLHIDO'])){
    //     $value = "Ñ.RECOLHIDO";
    //   }
    //   if(Str::containsAll($value, ['CLIENTE', 'AUSENTE'])){
    //     $value = "CL.AUSENT";
    //   }
    //   if(Str::containsAll($value, ['CONCLUÍDO'])){
    //     $value = "CONC";
    //   }
    //   if(Str::containsAll($value, ['(SUP)', 'TROCA', 'CABO'])){
    //     $value = "TROC.CABO";
    //   }
    //   if(Str::containsAll($value, ['(SUP)', 'TROCA', 'FIBRA'])){
    //     $value = "TROC.FIBRA";
    //   }
    //   return $value;
    // }
}
