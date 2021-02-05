<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Artesaos\Defender\Traits\HasDefender;
use Illuminate\Notifications\Notifiable;

/**
 * Class FrUsuario.
 *
 * @package namespace App\Entities;
 */

class FrUsuario extends Authenticatable
{
    use Notifiable, HasDefender;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'pgsql';
    protected $table = "public.fr_usuario";
    protected $primaryKey = 'usr_codigo';
    protected $fillable = [];

    public function perfis(){
        return $this->belongsToMany('App\Entities\MkWsPerfil', 'mk_ws_perfil_ope', 'id_ope', 'cd_perfil' );
    }
}
