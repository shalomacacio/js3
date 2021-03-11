<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\MkFatura;

/**
 * Class MkFaturaTransformer.
 *
 * @package namespace App\Transformers;
 */
class MkFaturaTransformer extends TransformerAbstract
{
    /**
     * Transform the MkFatura entity.
     *
     * @param \App\Entities\MkFatura $model
     *
     * @return array
     */
    public function transform(MkFatura $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
