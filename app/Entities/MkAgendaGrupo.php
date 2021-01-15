<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MkAgendaGrupo.
 *
 * @package namespace App\Entities;
 */
class MkAgendaGrupo extends Model implements Transformable
{
    use TransformableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $connection = 'pgsql';
    protected $table = "public.mk_agenda_grupo";
    protected $primaryKey = 'codagenda_grupo';
    protected $fillable = [];

}
