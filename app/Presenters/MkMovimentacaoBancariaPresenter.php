<?php

namespace App\Presenters;

use App\Transformers\MkMovimentacaoBancariaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MkMovimentacaoBancariaPresenter.
 *
 * @package namespace App\Presenters;
 */
class MkMovimentacaoBancariaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MkMovimentacaoBancariaTransformer();
    }
}
