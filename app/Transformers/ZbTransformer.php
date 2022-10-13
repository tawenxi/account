<?php

namespace App\Transformers;

use App\Model\Zb;
use League\Fractal\TransformerAbstract;

/**
 * Class ZbTransformer.
 */
class ZbTransformer extends TransformerAbstract
{
    /**
     * Transform the \Zb entity.
     *
     * @param \Zb $model
     *
     * @return array
     */
    public function transform(Zb $model)
    {
        return [
            'id'         => (int) $model->id,
            'ZBID'   => $model->ZBID,
            'data'   => $model->LR_RQ,
            'ZY'   => $model->ZY,
            'ZJXZMC'   => $model->ZJXZMC,

            'amount'   => $model->JE,
            'yeamount'   => $model->yeamount,
            'YSDWMC'   => $model->YSDWMC,

        ];
    }
}
