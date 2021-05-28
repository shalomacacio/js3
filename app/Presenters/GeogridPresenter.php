<?php

namespace App\Presenters;

use App\Transformers\GeogridTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GeogridPresenter.
 *
 * @package namespace App\Presenters;
 */
class GeogridPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GeogridTransformer();
    }
}
