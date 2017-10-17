<?php

namespace App\Presenters;

use App\Transformers\SalaryTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SalaryPresenter.
 */
class SalaryPresenter extends FractalPresenter
{
    /**
     * Transformer.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SalaryTransformer();
    }
}
