<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MkConexao.
 *
 * @package namespace App\Entities;
 */
class MkConexao extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'pgsql';
    protected $table = "public.mk_conexoes";
    protected $primaryKey = 'codconexao';
    protected $fillable = [];

    public function conexaoacct(){
        return $this->belongsTo('App\Entities\MkConexoesAcct', 'username', 'username');
    }
    public function analiseauth(){
        return $this->belongsTo('App\Entities\MkAnaliseAuth', 'username', 'username');
    }
}
