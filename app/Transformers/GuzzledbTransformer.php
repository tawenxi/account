<?php

namespace App\Transformers;

use App\Entities\Guzzledb;
use League\Fractal\TransformerAbstract;

/**
 * Class GuzzledbTransformer.
 */
class GuzzledbTransformer extends TransformerAbstract
{
    /**
     * Transform the \Guzzledb entity.
     *
     * @param \Guzzledb $model
     *
     * @return array
     */
    public function transform(Guzzledb $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
        ];
    }
}
