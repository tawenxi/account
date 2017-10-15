<?php

namespace App\Presenters;

use App\Transformers\CatTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CatPresenter
 *
 * @package namespace App\Presenters;
 */
class CatPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CatTransformer();
    }
}
