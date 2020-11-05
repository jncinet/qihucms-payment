<?php

namespace Qihucms\Payment\Gateways;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Qihucms\Payment\Contracts\GatewayApplicationInterface;
use Qihucms\Payment\Contracts\GatewayInterface;
use Qihucms\Payment\Gateways\Alipay\Support;
use Qihucms\Payment\Models\PayOrder;
use Yansongda\Pay\Pay;

/**
 * @method Response|View       app(PayOrder $order)      APP 支付
 * @method JsonResponse        pos(PayOrder $order)      刷卡支付
 * @method JsonResponse|View   scan(PayOrder $order)     扫码支付
 * @method JsonResponse        transfer(PayOrder $order) 帐户转账
 * @method Response            wap(PayOrder $order)      手机网站支付
 * @method Response            web(PayOrder $order)      电脑支付
 * @method JsonResponse        mini(PayOrder $order)     小程序支付
 */
class AliPay implements GatewayApplicationInterface
{
    protected $config;
    protected $order;

    /**
     * AliPay constructor.
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
     * @param array|string $order
     * @param string $type
     * @return JsonResponse
     * @throws \Yansongda\Pay\Exceptions\GatewayException
     * @throws \Yansongda\Pay\Exceptions\InvalidConfigException
     * @throws \Yansongda\Pay\Exceptions\InvalidSignException
     */
    public function find($order, string $type = 'wap'): JsonResponse
    {
        $result = Pay::alipay($this->config)->find($order, $type);

        return \response()->json($result);
    }

    /**
     * 退款
     *
     * @param array $order
     * @return JsonResponse
     * @throws \Yansongda\Pay\Exceptions\GatewayException
     * @throws \Yansongda\Pay\Exceptions\InvalidConfigException
     * @throws \Yansongda\Pay\Exceptions\InvalidSignException
     */
    public function refund($order): JsonResponse
    {
        $result = Pay::alipay($this->config)->refund($order);

        return \response()->json($result);
    }

    /**
     * 取消订单
     *
     * @param array|string $order
     * @return JsonResponse
     * @throws \Yansongda\Pay\Exceptions\GatewayException
     * @throws \Yansongda\Pay\Exceptions\InvalidConfigException
     * @throws \Yansongda\Pay\Exceptions\InvalidSignException
     */
    public function cancel($order): JsonResponse
    {
        $result = Pay::alipay($this->config)->cancel($order);

        return \response()->json($result);
    }

    /**
     * 关闭订单
     *
     * @param array|string $order
     * @return JsonResponse
     * @throws \Yansongda\Pay\Exceptions\GatewayException
     * @throws \Yansongda\Pay\Exceptions\InvalidConfigException
     * @throws \Yansongda\Pay\Exceptions\InvalidSignException
     */
    public function close($order): JsonResponse
    {
        $result = Pay::alipay($this->config)->close($order);

        return \response()->json($result);
    }

    public function verify()
    {
        $alipay = Pay::alipay($this->config);

        try {
            $data = $alipay->verify();

            if ($data->trade_status === 'TRADE_SUCCESS' || $data->trade_status === 'TRADE_FINISHED') {

                $order = PayOrder::where('id', $data->out_trade_no)
                    ->where('driver', 'alipay')
                    ->where('status', 0)
                    ->first();

                if ($order) {
                    // 响应参数
                    $order->result = [
                        'trade_no' => $data->trade_no,
                        'seller_id' => $data->seller_id,
                        'total_amount' => $data->total_amount,
                        'merchant_order_no' => $data->merchant_order_no,
                    ];

                    // 验入金额是否正确
                    if (bcsub($data->total_amount, $order->total_amount) == 0) {
                        $order->status = 1;
                    } else {
                        $order->status = 3;
                    }

                    $order->save();
                }
            }
        } catch (\Exception $e) {
            // $e->getMessage();
            \Log::alert('支付宝回调失败');
        }

        return $alipay->success();
    }
}