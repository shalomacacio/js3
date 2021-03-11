<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MkMovimentacaoBancaria.
 *
 * @package namespace App\Entities;
 */
class MkMovimentacaoBancaria extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'pgsql';
    protected $table = "public.mk_movimentacao_bancaria";
    protected $primaryKey = 'codmovcaixa';
    protected $fillable = [];

}
