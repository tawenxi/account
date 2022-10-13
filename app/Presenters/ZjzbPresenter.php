<?php

namespace App\Presenters;

use App\Transformers\ZjzbTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ZjzbPresenter
 *
 * @package namespace App\Presenters;
 */
class ZjzbPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ZjzbTransformer();
    }
}
