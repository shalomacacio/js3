<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\MkMovimentacaoBancaria;

/**
 * Class MkMovimentacaoBancariaTransformer.
 *
 * @package namespace App\Transformers;
 */
class MkMovimentacaoBancariaTransformer extends TransformerAbstract
{
    /**
     * Transform the MkMovimentacaoBancaria entity.
     *
     * @param \App\Entities\MkMovimentacaoBancaria $model
     *
     * @return array
     */
    public function transform(MkMovimentacaoBancaria $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
