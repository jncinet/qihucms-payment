<?php

namespace Qihucms\Payment\Gateways\Alipay;

use Illuminate\View\View;
use Qihucms\Payment\Contracts\GatewayInterface;
use Qihucms\Payment\Models\PayOrder;
use Yansongda\Pay\Pay;

class AppGateway extends Gateway implements GatewayInterface
{
    /**
     * @param PayOrder $order
     * @return View|\Symfony\Component\HttpFoundation\Response
     */
    public function pay(PayOrder $order)
    {
        // APP 通过POST请求获取支付参数
        if (\request()->isMethod('POST')) {
            return Pay::alipay($this->config)->app([
                'out_trade_no' => $order->id,
                'total_amount' => $order->total_amount,
                'subject' => $order->subject,
            ]);
        }

        // GET 视图页跳转到小程序支付页
        return view('payment::alipay.app', compact('order'));
    }
}