<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Zfpz;

/**
 * Class ZfpzTransformer
 * @package namespace App\Transformers;
 */
class ZfpzTransformer extends TransformerAbstract
{

    /**
     * Transform the \Zfpz entity
     * @param \Zfpz $model
     *
     * @return array
     */
    public function transform(Zfpz $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
