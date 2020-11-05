<?php

namespace Qihucms\Payment\Gateways;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Qihucms\Payment\Contracts\GatewayApplicationInterface;
use Qihucms\Payment\Contracts\GatewayInterface;
use Qihucms\Payment\Gateways\Wechat\Support;
use Qihucms\Payment\Models\PayOrder;
use Yansongda\Pay\Pay;

/**
 * @method JsonResponse|View    app(PayOrder $order)           APP 支付
 * @method JsonResponse         groupRedpack(PayOrder $order)  分裂红包
 * @method JsonResponse|View    miniapp(PayOrder $order)       小程序支付
 * @method JsonResponse|View    mp(PayOrder $order)            公众号支付
 * @method JsonResponse         pos(PayOrder $order)           刷卡支付
 * @method JsonResponse         redpack(PayOrder $order)       普通红包
 * @method JsonResponse|View    scan(PayOrder $order)          扫码支付
 * @method JsonResponse         transfer(PayOrder $order)      企业付款
 * @method RedirectResponse     wap(PayOrder $order)           H5 支付
 */
class Wechat implements GatewayApplicationInterface
{
    protected $config;
    protected $order;

    /**
     * Wechat constructor.
     *
     */
    public function __construct()
    {
        $this->config = Support::config();
    }

    /**
     * @param $method
     * @param $params
     * @return View|JsonResponse
     */
    public function __call($method, $params)
    {
        return $this->pay($method, ...$params);
    }

    /**
     * @param $gateway
     * @param PayOrder $order
     * @return View|JsonResponse
     */
    public function pay($gateway, PayOrder $order)
    {
        $this->order = $order;

        $gateway = get_class($this) . '\\' . Str::studly($gateway) . 'Gateway';

        if (class_exists($gateway)) {
            return $this->makePay($gateway);
        }

        $msg = '无效的操作请求';

        if (\request()->isMethod('POST')) {
            return \response()->json([$msg], 422);
        }

        return view('payment::error', compact('msg'));
    }

    /**
     * @param string $gateway
     * @return View|JsonResponse
     */
    protected function makePay(string $gateway)
    {
        $app = new $gateway($this->config);

        if ($app instanceof GatewayInterface) {
            return $app->pay($this->order);
        }

        $msg = '无效的支付方式';

        if (\request()->isMethod('POST')) {
            return \response()->json([$msg], 422);
        }

        return view('payment::error', compact('msg'));
    }

    /**
     * 查询订单
     *
     * @param string|array $order
     * @param string $type
     * @return JsonResponse
     * @throws \Yansongda\Pay\Exceptions\GatewayException
     * @throws \Yansongda\Pay\Exceptions\InvalidArgumentException
     * @throws \Yansongda\Pay\Exceptions\InvalidSignException
     */
    public function find($order, string $type = 'wap'): JsonResponse
    {
        $result = Pay::wechat($this->config)->find($order, $type);

        return \response()->json($result);
    }

    /**
     * 退款
     *
     * @param array $order
     * @return JsonResponse
     * @throws \Yansongda\Pay\Exceptions\GatewayException
     * @throws \Yansongda\Pay\Exceptions\InvalidArgumentException
     * @throws \Yansongda\Pay\Exceptions\InvalidSignException
     */
    public function refund(array $order): JsonResponse
    {
        $result = Pay::wechat($this->config)->refund($order);

        return \response()->json($result);
    }

    /**
     * 关闭订单
     *
     * @param array|string $order
     * @return JsonResponse
     * @throws \Yansongda\Pay\Exceptions\GatewayException
     * @throws \Yansongda\Pay\Exceptions\InvalidArgumentException
     * @throws \Yansongda\Pay\Exceptions\InvalidSignException
     */
    public function cancel($order): JsonResponse
    {
        $result = Pay::wechat($this->config)->close($order);

        return \response()->json($result);
    }

    /**
     * 取消订单
     *
     * @param array|string $order
     * @return JsonResponse
     */
    public function close($order): JsonResponse
    {
        return \response()->json(['Wechat Do Not Have Cancel API!']);
    }

    /**
     * @return mixed
     * @throws \Yansongda\Pay\Exceptions\InvalidArgumentException
     */
    public function verify()
    {
        $wechat = Pay::wechat($this->config);

        try {
            $data = $wechat->verify();
            if ($data->return_code === 'SUCCESS' || $data->result_code === 'SUCCESS') {

                $order = PayOrder::where('id', $data->out_trade_no)
                    ->where('driver', 'alipay')
                    ->where('status', 0)
                    ->first();

                if ($order) {
                    // 响应参数
                    $order->result = [
                        'appid' => $data->appid,
                        'mch_id' => $data->mch_id,
                        'device_info' => $data->device_info,
                        'is_subscribe' => $data->is_subscribe,
                        'trade_type' => $data->trade_type,
                        'bank_type' => $data->bank_type,
                        'fee_type' => $data->fee_type,
                        'total_fee' => $data->total_fee,
                        'transaction_id' => $data->transaction_id,
                    ];

                    // 验入金额是否正确
                    if (bcsub($data->total_fee, $order->total_amount) == 0) {
                        $order->status = 1;
                    } else {
                        $order->status = 3;
                    }

                    $order->save();
                }
            }
        } catch (\Exception $e) {
            // $e->getMessage();
            \Log::alert('微信支付回调失败');
        }

        return $wechat->success();
    }
}