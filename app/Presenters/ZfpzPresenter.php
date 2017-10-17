<?php

namespace App\Presenters;

use App\Transformers\ZfpzTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ZfpzPresenter
 *
 * @package namespace App\Presenters;
 */
class ZfpzPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ZfpzTransformer();
    }
}
