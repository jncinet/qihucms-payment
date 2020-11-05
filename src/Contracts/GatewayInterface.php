<?php

namespace Qihucms\Payment\Contracts;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Qihucms\Payment\Models\PayOrder;

interface GatewayInterface
{
    /**
     * @param PayOrder $order
     * @return JsonResponse|Response|View|RedirectResponse
     */
    public function pay(PayOrder $order);
}