<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\MkConta;

/**
 * Class MkContaTransformer.
 *
 * @package namespace App\Transformers;
 */
class MkContaTransformer extends TransformerAbstract
{
    /**
     * Transform the MkConta entity.
     *
     * @param \App\Entities\MkConta $model
     *
     * @return array
     */
    public function transform(MkConta $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
