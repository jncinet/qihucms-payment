<?php

namespace Qihucms\Payment\Gateways\Wechat;

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
        $order = $this->order;

        $result = Pay::wechat($this->config)->pos([
            'out_trade_no' => $order->id,
            'body' => $order->subject,
            'total_fee' => bcmul($order->total_amount, 100),
            'auth_code' => $order->params['auth_code']
        ]);

        return \response()->json($result);
    }
}