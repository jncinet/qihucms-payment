<?php

namespace Qihucms\Payment\Gateways\Wechat;

use Qihucms\Payment\Contracts\GatewayInterface;
use Qihucms\Payment\Models\PayOrder;
use Yansongda\Pay\Pay;

class WapGateway extends Gateway implements GatewayInterface
{
    /**
     * @param PayOrder $order
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function pay(PayOrder $order)
    {
        $order = $this->order;

        return Pay::wechat($this->config)->wap([
            'out_trade_no' => $order->id,
            'body' => $order->subject,
            'total_fee' => bcmul($order->total_amount, 100),
        ]);
    }
}