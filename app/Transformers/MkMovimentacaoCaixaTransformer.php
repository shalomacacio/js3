<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\MkMovimentacaoCaixa;

/**
 * Class MkMovimentacaoCaixaTransformer.
 *
 * @package namespace App\Transformers;
 */
class MkMovimentacaoCaixaTransformer extends TransformerAbstract
{
    /**
     * Transform the MkMovimentacaoCaixa entity.
     *
     * @param \App\Entities\MkMovimentacaoCaixa $model
     *
     * @return array
     */
    public function transform(MkMovimentacaoCaixa $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
