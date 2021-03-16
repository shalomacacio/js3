<?php

namespace App\Presenters;

use App\Transformers\MkContaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MkContaPresenter.
 *
 * @package namespace App\Presenters;
 */
class MkContaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MkContaTransformer();
    }
}
