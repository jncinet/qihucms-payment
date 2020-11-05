<?php

namespace Qihucms\Payment\Gateways\Wechat;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Qihucms\Payment\Contracts\GatewayInterface;
use Qihucms\Payment\Models\PayOrder;
use Yansongda\Pay\Pay;

class MiniappGateway extends Gateway implements GatewayInterface
{
    /**
     * @param PayOrder $order
     * @return JsonResponse|View
     */
    public function pay(PayOrder $order)
    {
        if (\request()->isMethod('POST')) {
            $result = Pay::wechat($this->config)->miniapp([
                'out_trade_no' => $order->id,
                'body' => $order->subject,
                'total_fee' => bcmul($order->total_amount, 100),
                // 请在请求时传入
                'openid' => \request()->input('openid'),
            ]);
            return \response()->json($result);
        }

        return view('payment::wechat.miniapp', compact('order'));
    }
}