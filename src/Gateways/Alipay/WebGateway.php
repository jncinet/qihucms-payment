<?php

namespace Qihucms\Payment\Gateways\Alipay;

use Qihucms\Payment\Contracts\GatewayInterface;
use Qihucms\Payment\Models\PayOrder;
use Yansongda\Pay\Pay;

class WebGateway extends Gateway implements GatewayInterface
{
    /**
     * @param PayOrder $order
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pay(PayOrder $order)
    {
        return Pay::alipay($this->config)->web([
            'out_trade_no' => $order->id,
            'total_amount' => $order->total_amount,
            'subject' => $order->subject,
        ]);
    }
}