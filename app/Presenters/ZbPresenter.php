<?php

namespace App\Presenters;

use App\Transformers\ZbTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ZbPresenter.
 */
class ZbPresenter extends FractalPresenter
{
    /**
     * Transformer.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ZbTransformer();
    }
}
