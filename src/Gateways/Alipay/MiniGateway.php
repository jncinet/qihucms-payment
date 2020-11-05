<?php

namespace Qihucms\Payment\Gateways\Alipay;

use Illuminate\Http\JsonResponse;
use Qihucms\Payment\Contracts\GatewayInterface;
use Qihucms\Payment\Models\PayOrder;
use Yansongda\Pay\Pay;

class MiniGateway extends Gateway implements GatewayInterface
{
    /**
     * @param PayOrder $order
     * @return JsonResponse
     */
    public function pay(PayOrder $order)
    {
        $result = Pay::alipay($this->config)->mini([
            'out_trade_no' => $order->id,
            'subject' => $order->subject,
            'total_amount' => $order->total_amount,
            'buyer_id' => $order->params['buyer_id'],
        ]);

        return \response()->json($result);
    }
}