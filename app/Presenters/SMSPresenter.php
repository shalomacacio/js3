<?php

namespace App\Presenters;

use App\Transformers\SMSTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SMSPresenter.
 *
 * @package namespace App\Presenters;
 */
class SMSPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SMSTransformer();
    }
}
