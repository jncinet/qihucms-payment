<?php

namespace Qihucms\Payment\Gateways\Wechat;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Qihucms\Payment\Contracts\GatewayInterface;
use Qihucms\Payment\Models\PayOrder;
use Yansongda\Pay\Pay;

class AppGateway extends Gateway implements GatewayInterface
{
    /**
     * @param PayOrder $order
     * @return JsonResponse|View
     */
    public function pay(PayOrder $order)
    {
        $result = Pay::wechat($this->config)->app([
            'out_trade_no' => $order->id,
            'body' => $order->subject,
            'total_fee' => bcmul($order->total_amount, 100),
        ]);

        if (\request()->isMethod('POST')) {
            return \response()->json($result);
        }

        return view('payment::wechat.app', compact('result', 'order'));
    }
}