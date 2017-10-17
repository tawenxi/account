<?php

namespace App\Presenters;

use App\Transformers\SalaryTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SalaryPresenter
 *
 * @package namespace App\Presenters;
 */
class SalaryPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SalaryTransformer();
    }
}
