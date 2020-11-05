<?php

namespace Qihucms\Payment;

use Illuminate\Support\Str;
use Qihucms\Payment\Contracts\GatewayApplicationInterface;
use Yansongda\Pay\Exceptions\InvalidGatewayException;

/**
 * @method static Alipay alipay() 支付宝
 * @method static Wechat wechat() 微信
 */
class Pay
{
    /**
     * @param $method
     * @param $params
     * @return GatewayApplicationInterface
     * @throws InvalidGatewayException
     */
    public static function __callStatic($method, $params): GatewayApplicationInterface
    {
        $app = new self();

        return $app->create($method);
    }

    /**
     * @param $method
     * @return GatewayApplicationInterface
     * @throws InvalidGatewayException
     */
    protected function create($method): GatewayApplicationInterface
    {
        $gateway = __NAMESPACE__ . '\\Gateways\\' . Str::studly($method);

        if (class_exists($gateway)) {
            return self::make($gateway);
        }

        throw new InvalidGatewayException("Gateway [{$method}] Not Exists");
    }

    /**
     * @param $gateway
     * @return GatewayApplicationInterface
     * @throws InvalidGatewayException
     */
    protected function make($gateway): GatewayApplicationInterface
    {
        $app = new $gateway();

        if ($app instanceof GatewayApplicationInterface) {
            return $app;
        }

        throw new InvalidGatewayException("Gateway [{$gateway}] Must Be An Instance Of GatewayApplicationInterface");
    }
}