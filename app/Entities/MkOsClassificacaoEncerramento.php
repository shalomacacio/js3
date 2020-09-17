<?php

namespace App\Entities;

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

}
