@extends('payment::layouts.layout')

@section('title', '支付结果')

@section('content')
    <div class="bg-light text-center py-2" style="margin-bottom: 1px;">支付结果</div>

    <div class="mb-2 py-5 text-center bg-white">
        <img width="12%" src="{{ asset('vendor/payment/error.svg') }}" alt="支付失败">
        <div class="pt-2">{{ __('payment::pay_order.status.value')[$order->status] }}</div>
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
        @if($order->status == 0)
            <a href="{{ route('api.payment.pay', ['id' => $order->id]) }}" class="btn btn-block btn-primary">重新支付</a>
        @endif
        <a href="{{ $order->params['order_url'] }}" class="btn btn-block btn-success">查看订单</a>
        <a href="{{ $order->params['home_url'] }}" class="btn btn-block btn-secondary">返回首页</a>
    </div>
@endsection