@extends('payment::layouts.layout')

@section('title', '错误提示')

@section('content')
    <div class="bg-light text-center py-2" style="margin-bottom: 1px;">错误提示</div>

    <div class="mb-2 py-5 text-center bg-white">
        <img width="12%" src="{{ asset('vendor/payment/error.svg') }}" alt="支付失败">
        <div class="pt-2">{{ $msg }}</div>
    </div>

    <div class="p-3">
        <a href="JavaScript:history.go(-2);" class="btn btn-block btn-secondary">返回</a>
    </div>
@endsection