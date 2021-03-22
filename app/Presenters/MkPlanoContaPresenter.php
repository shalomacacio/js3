<?php

namespace App\Presenters;

use App\Transformers\MkPlanoContaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MkPlanoContaPresenter.
 *
 * @package namespace App\Presenters;
 */
class MkPlanoContaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MkPlanoContaTransformer();
    }
}
