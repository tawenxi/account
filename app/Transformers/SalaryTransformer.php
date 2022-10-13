<?php

namespace App\Transformers;

use App\Entities\Salary;
use League\Fractal\TransformerAbstract;

/**
 * Class SalaryTransformer.
 */
class SalaryTransformer extends TransformerAbstract
{
    /**
     * Transform the \Salary entity.
     *
     * @param \Salary $model
     *
     * @return array
     */
    public function transform(Salary $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
        ];
    }
}
