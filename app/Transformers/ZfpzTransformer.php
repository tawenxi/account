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
            'ZBID'   => $model->zb->ZBID,
            'data'   => $model->QS_RQ,
            'data'   => $model->ZY,
            'SKR'   => $model->SKR,
            'DW'   => $model->YSDWMC,
            'amount'   => $model->JE,
            'ZFFS'   => $model->ZFFSMC,




            /* place your other model properties here */

            // 'created_at' => $model->created_at,
            // 'updated_at' => $model->updated_at,
        ];
    }
}
