<?php

namespace Qihucms\Payment\Gateways\Wechat;

use Illuminate\Http\JsonResponse;
use Qihucms\Payment\Contracts\GatewayInterface;
use Qihucms\Payment\Models\PayOrder;
use Yansongda\Pay\Pay;

class TransferGateway extends Gateway implements GatewayInterface
{
    /**
     * @param PayOrder $order
     * @return JsonResponse
     */
    public function pay(PayOrder $order)
    {
        $order = $this->order;

        $result = Pay::wechat($this->config)->transfer([
            'partner_trade_no' => $order->params['partner_trade_no'],
            'openid' => $order->params['openid'],
            'check_name' => $order->params['check_name'],
            // 转为分
            'amount' => bcmul($order->amount, 100),
            'desc' => $order->params['desc'],
            'type' => $order->params['type']
        ]);

        return \response()->json($result);
    }
}