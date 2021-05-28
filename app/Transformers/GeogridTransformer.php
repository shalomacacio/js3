<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Geogrid;

/**
 * Class GeogridTransformer.
 *
 * @package namespace App\Transformers;
 */
class GeogridTransformer extends TransformerAbstract
{
    /**
     * Transform the Geogrid entity.
     *
     * @param \App\Entities\Geogrid $model
     *
     * @return array
     */
    public function transform(Geogrid $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
