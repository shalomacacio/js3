<?php

namespace App\Presenters;

use App\Transformers\MkAtendimentoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MkAtendimentoPresenter.
 *
 * @package namespace App\Presenters;
 */
class MkAtendimentoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MkAtendimentoTransformer();
    }
}
