<?php

namespace Qihucms\Payment\Contracts;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Qihucms\Payment\Models\PayOrder;

interface GatewayApplicationInterface
{
    /**
     * 支付
     *
     * @param string $gateway
     * @param PayOrder $order
     * @return JsonResponse|Response|View|RedirectResponse
     */
    public function pay($gateway, PayOrder $order);

    /**
     * 查询订单
     *
     * @param string|array $order
     * @param string $type
     * @return JsonResponse
     */
    public function find($order, string $type): JsonResponse;

    /**
     * 退款
     *
     * @param array $order
     * @return JsonResponse
     */
    public function refund(array $order): JsonResponse;

    /**
     * 取消订单
     *
     * @param string|array $order
     * @return JsonResponse
     */
    public function cancel($order): JsonResponse;

    /**
     * 关闭订单
     *
     * @param string|array $order
     * @return JsonResponse
     */
    public function close($order): JsonResponse;

    /**
     * @return mixed
     */
    public function verify();
}