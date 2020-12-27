<?php

namespace Qihucms\Payment\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Qihucms\Payment\Contracts\GatewayApplicationInterface;
use Qihucms\Payment\Gateways\Alipay\Support;
use Qihucms\Payment\Models\PayOrder;
use Yansongda\Pay\Pay;

class PaymentController extends ApiController
{
    /**
     * 发起支付
     *
     * @param int $id 订单ID
     * @return mixed
     */
    public function pay($id)
    {

        $order = PayOrder::find($id);

        if ($order) {
            $driver = 'Qihucms\\Payment\\Gateways\\' . Str::studly($order->driver);

            if (class_exists($driver)) {
                $app = new $driver();
                if ($app instanceof GatewayApplicationInterface) {
                    return $app->{$order->gateway}($order);
                } else {
                    $msg = __('payment::message.channel_not_find');
                }
            } else {
                $msg = __('payment::message.invalid_order_id');
            }
        } else {
            $msg = __('payment::message.order_not_find');
        }

        if (request()->isMethod('POST')) {
            return response()->json([$msg], 422);
        }

        return view('payment::error', compact('msg'));
    }

    /**
     * 支付回调
     *
     * @param $driver
     * @return null|\Symfony\Component\HttpFoundation\Response
     */
    public function notify($driver)
    {
        $driver = 'Qihucms\\Payment\\Gateways\\' . Str::studly($driver);

        if (class_exists($driver)) {
            $app = new $driver();
            if ($app instanceof GatewayApplicationInterface) {
                return $app->verify();
            }
        }

        return response('error', 400);
    }

    /**
     * 订单支付结果
     *
     * @param Request $request
     * @return mixed
     * @throws \Yansongda\Pay\Exceptions\InvalidConfigException
     * @throws \Yansongda\Pay\Exceptions\InvalidSignException
     */
    public function completed(Request $request)
    {
        // 微信等手动跳转参数
        $id = $request->get('id');

        if (!$id) {
            // 支付宝
            $result = Pay::alipay(Support::config())->verify();

            if ($result) {
                $id = $result->out_trade_no;
            }
        }

        if ($id) {
            $order = PayOrder::find($id);

            // 支付成功 = 1
            if ($order->status == 1) {
                return view('payment::success', compact('order'));
            }

            return view('payment::fail', compact('order'));

        }

        $msg = __('payment::message.order_not_find');

        return view('payment::error', compact('msg'));
    }
}