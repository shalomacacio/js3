<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MkWsPerfil.
 *
 * @package namespace App\Entities;
 */
class MkWsPerfil extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'pgsql';
    protected $table = "public.mk_ws_perfil";
    protected $primaryKey = 'codwsperfil';
    protected $fillable = [];


    public function usuarios(){
        return $this->belongsToMany('App\Entities\FrUsuario');
    }

}
