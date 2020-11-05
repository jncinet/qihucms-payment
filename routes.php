<?php

use Illuminate\Routing\Router;

// 接口
Route::group([
    'prefix' => 'payment',
    'namespace' => 'Qihucms\Payment\Controllers\Api',
    'middleware' => ['api'],
    'as' => 'api.'
], function (Router $router) {
    $router->any('pay/{id}', 'PaymentController@pay')
        ->name('payment.pay');
    $router->any('{driver}/notify', 'PaymentController@notify')
        ->name('payment.notify');
    $router->get('completed', 'PaymentController@completed')
        ->name('payment.completed');
});

// 后台管理
Route::group([
    'prefix' => config('admin.route.prefix') . '/payment',
    'namespace' => 'Qihucms\Payment\Controllers\Admin',
    'middleware' => config('admin.route.middleware'),
    'as' => 'admin.'
], function (Router $router) {
    $router->resource('pay-orders', 'PayOrdersController');
});