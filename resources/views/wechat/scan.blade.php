@extends('payment::layouts.layout')

@section('title', '扫码支付')

@section('content')
    <div class="bg-light text-center py-2" style="margin-bottom: 1px;">发起支付</div>

    <div class="mb-2 py-4 text-center bg-white">
        {!! QrCode::size(300)->generate($result->code_url); !!}
        <div class="pt-2">扫描二维码付款</div>
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
        <a href="{{ route('payment.completed', ['id' => $order->id ]) }}" class="btn btn-block btn-primary">付款完成</a>
        <a href="{{ $order->params['order_url'] }}" class="btn btn-block btn-success">查看订单</a>
        <a href="{{ $order->params['home_url'] }}" class="btn btn-block btn-secondary">返回首页</a>
    </div>
@endsection