<?php

namespace App\Presenters;

use App\Transformers\GuzzledbTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GuzzledbPresenter.
 */
class GuzzledbPresenter extends FractalPresenter
{
    /**
     * Transformer.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GuzzledbTransformer();
    }
}
