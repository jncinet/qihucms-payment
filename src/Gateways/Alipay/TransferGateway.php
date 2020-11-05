<?php

namespace Qihucms\Payment\Gateways\Alipay;

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
        $result = Pay::alipay($this->config)->transfer([
            'out_biz_no' => $order->params['out_biz_no'],
            'trans_amount' => $order->params['trans_amount'],
            'product_code' => $order->params['product_code'],
            'payee_info' => [
                'identity' => $order->params['identity'],
                'identity_type' => $order->params['identity_type'],
            ],
        ]);

        return \response()->json($result);
    }
}