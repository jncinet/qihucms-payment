<?php

namespace Qihucms\Payment\Gateways\Wechat;

class Support
{
    public static function config(): array
    {
        return [
            'appid' => config('qihu.wechat_open_app_id'), // APP APPID
            'app_id' => config('qihu.wechat_mp_appid'), // 公众号 APPID
            'miniapp_id' => config('qihu.wechat_mini_appid'), // 小程序 APPID
            'mch_id' => config('qihu.wechat_pay_mch_id'),
            'key' => config('qihu.wechat_pay_key'),
            'notify_url' => route('api.payment.notify', ['driver' => 'wechat']),
            'cert_client' => './cert/apiclient_cert.pem', // optional，退款等情况时用到
            'cert_key' => './cert/apiclient_key.pem', // optional，退款等情况时用到
        ];
    }
}