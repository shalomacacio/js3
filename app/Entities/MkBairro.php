<?php

namespace App\Entities;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MkBairro.
 *
 * @package namespace App\Entities;
 */
class MkBairro extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'pgsql';
    protected $table = "public.mk_bairros";
    protected $primaryKey = 'codbairro';
    protected $fillable = [];

    // MUTATORS
    public function getBairroAttribute($value)
    {
      if(Str::containsAll($value, ['Novo', 'Parque', 'Iracema'])){
        $value = "N.IRACEMA";
      }
      if(Str::contains($value, ['Novo'])){
        $value = Str::replaceArray('Novo', ['N.'], $value);
      }
      if(Str::contains($value, ['Maranguape'])){
        $value = Str::replaceArray('Maranguape', ['MPE'], $value);
      }
      if(Str::contains($value, ['Parque'])){
        $value = Str::replaceArray('Parque', ['P'], $value);
      }
      if(Str::contains($value, ['São'])){
        $value = Str::replaceArray('São', ['S'], $value);
      }
      if(Str::contains($value, ['Planalto'])){
        $value = Str::replaceArray('Planalto', ['PL'], $value);
      }
      if(Str::contains($value, ['Santa'])){
        $value = Str::replaceArray('Santa', ['ST'], $value);
      }
      if(Str::contains($value, ['Outra'])){
        $value = Str::replaceArray('Outra', ['O'], $value);
      }
      if(Str::containsAll($value, ['Senador', 'Carlos', 'Jereissati'])){
        $value = "JEREISSATI";
      }
      if(Str::containsAll($value, ['Cônego', 'Raimundo', 'Pinto'])){
        $value = "CÔNEGO R";
      }
      if(Str::containsAll($value, ['Santos','Dumont'])){
        $value = "S DUMONT";
      }
      if(Str::containsAll($value, ['Pau','Serrado'])){
        $value = "P.SERRADO";
      }
      if(Str::containsAll($value, ['Luzardo','Viana'])){
        $value = "LUZARDO";
      }
      return Str::upper($value);
    }

}
