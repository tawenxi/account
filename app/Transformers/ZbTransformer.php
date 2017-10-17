<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Zb;

/**
 * Class ZbTransformer
 * @package namespace App\Transformers;
 */
class ZbTransformer extends TransformerAbstract
{

    /**
     * Transform the \Zb entity
     * @param \Zb $model
     *
     * @return array
     */
    public function transform(Zb $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
