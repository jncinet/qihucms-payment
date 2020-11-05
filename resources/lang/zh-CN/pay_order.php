<?php

return [
    'id' => '订单号',
    'user_id' => '操作会员',
    'driver' => '业务渠道',
    'gateway' => '业务方式',
    'type' => '业务类型',
    'subject' => '订单标题',
    'total_amount' => '订单金额',
    'params' => '业务参数',
    'result' => '响应数据',
    'status' => [
        'label' => '业务状态',
        'value' => ['等待处理', '交易成功', '交易失败', '支付金额异常', '取消订单', '关闭订单', '申请退款', '退款成功']
    ]
];