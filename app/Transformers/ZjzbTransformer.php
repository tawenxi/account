<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Zjzb;

/**
 * Class ZjzbTransformer
 * @package namespace App\Transformers;
 */
class ZjzbTransformer extends TransformerAbstract
{

    /**
     * Transform the Zjzb entity
     * @param App\Entities\Zjzb $model
     *
     * @return array
     */
    public function transform(Zjzb $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
