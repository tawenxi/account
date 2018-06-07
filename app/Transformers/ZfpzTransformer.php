<?php

namespace App\Transformers;

use App\MOdel\Zfpz;
use League\Fractal\TransformerAbstract;

/**
 * Class ZfpzTransformer.
 */
class ZfpzTransformer extends TransformerAbstract
{
    /**
     * Transform the \Zfpz entity.
     *
     * @param \Zfpz $model
     *
     * @return array
     */
    public function transform(Zfpz $model)
    {
        return [
            'id'         => (int) $model->id,
            'title'   => $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
        ];
    }
}
