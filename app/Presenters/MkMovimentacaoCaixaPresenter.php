<?php

namespace App\Presenters;

use App\Transformers\MkMovimentacaoCaixaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MkMovimentacaoCaixaPresenter.
 *
 * @package namespace App\Presenters;
 */
class MkMovimentacaoCaixaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MkMovimentacaoCaixaTransformer();
    }
}
