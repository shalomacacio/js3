<?php

namespace App\Entities;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MkOsMobileAtuStatus.
 *
 * @package namespace App\Entities;
 */
class MkOsMobileAtuStatus extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'pgsql';
    protected $table = "public.mk_os_mobile_atu_status";
    protected $primaryKey = 'codosatustatus';
    protected $fillable = [];

    public function getDescricaoAttribute($value)
    {
      if(Str::containsAll($value, ['Visualização ', 'de O.S' ])){
        $value = "VIS O.S";
      }
      return $value;
    }

}
