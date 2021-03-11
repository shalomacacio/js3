<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MkMovimentacaoCaixa.
 *
 * @package namespace App\Entities;
 */
class MkMovimentacaoCaixa extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'pgsql';
    protected $table = "public.mk_movimentacao_caixa";
    protected $primaryKey = 'codmovcaixa';
    protected $fillable = [];

}
