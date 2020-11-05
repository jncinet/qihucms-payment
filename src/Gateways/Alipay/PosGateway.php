<?php

namespace Qihucms\Payment\Gateways\Alipay;

use Illuminate\Http\JsonResponse;
use Qihucms\Payment\Contracts\GatewayInterface;
use Qihucms\Payment\Models\PayOrder;
use Yansongda\Pay\Pay;

class PosGateway extends Gateway implements GatewayInterface
{
    /**
     * @param PayOrder $order
     * @return JsonResponse
     */
    public function pay(PayOrder $order)
    {
        $result = Pay::alipay($this->config)->pos([
            'out_trade_no' => $order->id,
            'total_amount' => $order->total_amount,
            'subject' => $order->subject,
            'auth_code' => $order->params['auth_code'],
        ]);

        return \response()->json($result);
    }
}