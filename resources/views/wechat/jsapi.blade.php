@extends('payment::layouts.layout')

@section('title', '微信支付JS支付')

@section('heads')
    <script src="//res.wx.qq.com/open/js/jweixin-1.6.0.js"></script>
@endsection

@section('content')
    <div class="bg-light text-center py-2" style="margin-bottom: 1px;">发起支付</div>

    <div class="mb-2 py-5 text-center bg-white">
        <img width="12%" src="{{ asset('vendor/payment/waiting.svg') }}" alt="正在请求支付">
        <div class="pt-2">正在请求支付</div>
    </div>

    <div class="bg-white p-3">
        <div class="d-flex justify-content-between mb-2">
            <div class="text-secondary">订单编号：</div>
            <div>{{ $order->id }}</div>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <div class="text-secondary">订单标题：</div>
            <div>{{ $order->subject }}</div>
        </div>
        <div class="d-flex justify-content-between">
            <div class="text-secondary">支付金额：</div>
            <div>¥{{ $order->total_amount }}元</div>
        </div>
    </div>

    <div class="p-3">
        <a href="{{ $order->params['order_url'] }}" class="btn btn-block btn-success">付款成功，查看订单</a>
        <a href="{{ $order->params['home_url'] }}" class="btn btn-block btn-secondary">返回首页</a>
    </div>
@endsection

@push('scripts')
    <script language="JavaScript">
        function onBridgeReady() {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest', {!! $result !!},
                function () {
                    location.href = "{{ route('payment.completed', ['id' => $order->id ]) }}";
                });
        }

        if (typeof WeixinJSBridge == "undefined") {
            if (document.addEventListener) {
                document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
            } else if (document.attachEvent) {
                document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
                document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
            }
        } else {
            onBridgeReady();
        }
    </script>
@endpush