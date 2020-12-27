<?php

use Illuminate\Routing\Router;

// 接口
Route::group([
    'prefix' => config('qihu.payment_prefix', 'payment'),
    'namespace' => 'Qihucms\Payment\Controllers\Api',
    'middleware' => ['api'],
    'as' => 'api.payment.'
], function (Router $router) {
    $router->any('pay/{id}', 'PaymentController@pay')
        ->name('pay');
    $router->any('{driver}/notify', 'PaymentController@notify')
        ->name('notify');
    $router->get('completed', 'PaymentController@completed')
        ->name('completed');
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