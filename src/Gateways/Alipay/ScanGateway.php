<?php

namespace Qihucms\Payment\Gateways\Alipay;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Qihucms\Payment\Contracts\GatewayInterface;
use Qihucms\Payment\Models\PayOrder;
use Yansongda\Pay\Pay;

class ScanGateway extends Gateway implements GatewayInterface
{
    /**
     * @param PayOrder $order
     * @return JsonResponse|View
     */
    public function pay(PayOrder $order)
    {
        $result = Pay::alipay($this->config)->scan([
            'out_trade_no' => $order->id,
            'total_amount' => $order->total_amount,
            'subject' => $order->subject,
        ]);

        if (\request()->isMethod('POST')) {
            return \response()->json($result);
        }

        return view('payment::alipay.scan', compact('result', 'order'));
    }
}