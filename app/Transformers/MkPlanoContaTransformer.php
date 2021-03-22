<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\MkPlanoConta;

/**
 * Class MkPlanoContaTransformer.
 *
 * @package namespace App\Transformers;
 */
class MkPlanoContaTransformer extends TransformerAbstract
{
    /**
     * Transform the MkPlanoConta entity.
     *
     * @param \App\Entities\MkPlanoConta $model
     *
     * @return array
     */
    public function transform(MkPlanoConta $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
