<?php

namespace Qihucms\Payment\Gateways\Wechat;

use Illuminate\Http\JsonResponse;
use Qihucms\Payment\Contracts\GatewayInterface;
use Qihucms\Payment\Models\PayOrder;
use Yansongda\Pay\Pay;

class GroupRedpackGateway extends Gateway implements GatewayInterface
{
    /**
     * @param PayOrder $order
     * @return JsonResponse
     */
    public function pay(PayOrder $order)
    {
        $result = Pay::wechat($this->config)->groupRedpack([
            'mch_billno' => $order->params['mch_billno'],
            'send_name' => $order->params['send_name'],
            'total_amount' => bcmul($order->params['total_amount'], 100),
            're_openid' => $order->params['re_openid'],
            'total_num' => $order->params['total_num'],
            'wishing' => $order->params['wishing'],
            'act_name' => $order->params['act_name'],
            'remark' => $order->params['remark'],
        ]);

        return \response()->json($result);
    }
}