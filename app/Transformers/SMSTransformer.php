<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\SMS;

/**
 * Class SMSTransformer.
 *
 * @package namespace App\Transformers;
 */
class SMSTransformer extends TransformerAbstract
{
    /**
     * Transform the SMS entity.
     *
     * @param \App\Entities\SMS $model
     *
     * @return array
     */
    public function transform(SMS $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
