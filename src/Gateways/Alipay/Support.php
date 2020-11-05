<?php

namespace Qihucms\Payment\Gateways\Alipay;

class Support
{
    /**
     * @return array
     */
    public static function config(): array
    {
        return [
            'app_id' => \Cache::get('config_alipay_app_id'),
            'notify_url' => route('api.payment.notify', ['driver' => 'alipay']),
            'return_url' => route('api.payment.completed'),
            'ali_public_key' => \Cache::get('config_alipay_public_key'),
            'private_key' => \Cache::get('config_alipay_private_key')
        ];
    }
}