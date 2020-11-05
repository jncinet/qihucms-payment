<?php

namespace Qihucms\Payment\Gateways\Alipay;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Qihucms\Payment\Contracts\GatewayInterface;
use Qihucms\Payment\Models\PayOrder;

abstract class Gateway implements GatewayInterface
{
    protected $config;

    /**
     * Gateway constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * @param PayOrder $order
     * @return JsonResponse|Response|View
     */
    abstract public function pay(PayOrder $order);
}