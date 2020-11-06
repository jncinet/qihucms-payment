<?php

namespace Qihucms\Payment\Models;

use Illuminate\Database\Eloquent\Relations\MorphOne;

trait PayOrderable
{
    /**
     * @return MorphOne
     */
    public function pay_order(): MorphOne
    {
        return $this->morphOne('Qihucms\Payment\Models\PayOrder', 'orderable');
    }
}