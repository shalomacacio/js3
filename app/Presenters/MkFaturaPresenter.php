<?php

namespace App\Presenters;

use App\Transformers\MkFaturaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MkFaturaPresenter.
 *
 * @package namespace App\Presenters;
 */
class MkFaturaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MkFaturaTransformer();
    }
}
