<h1 align="center">支付管理</h1>

### 引用库
 
 基础支付扩展包：[yansongda/laravel-pay](https://github.com/yansongda/laravel-pay)  
 扫码支付二维码生成：[simplesoftwareio/simple-qrcode](https://github.com/SimpleSoftwareIO/simple-qrcode)

## 安装
```shell
$ composer require jncinet/qihucms-payment
```

## 开始
### 数据迁移
```shell
$ php artisan migrate
```
### 发布资源
```shell
$ php artisan vendor:publish --provider="Qihucms\Payment\PaymentServiceProvider"
```

### 添加后台管理菜单
+ 链接名称：支付记录  
+ 链接地址：payment/pay-orders

### 接口说明
#### 发起支付
+ 请求方式：ANY
+ 链接地址：payment/pay/{id=订单号}
+ 返回值：
  - GET 请求返回视图页
  - POST 请求返回JSON支付参数

#### 支付回调
+ 请求方式：ANY
+ 链接地址：payment/{driver=支付渠道}/notify
+ 返回值：SUCCESS

#### 订单支付结果
+ 请求方式：GET
+ 链接地址：payment/completed?id=订单号
+ 返回值：支付结果页面

## 数据库

### 支付订单表：pay_orders

| Field             | Type      | Length    | AllowNull | Default   | Comment       |
| :----             | :----     | :----     | :----     | :----     | :----         |
| id                | bigint    |           |           |           |               |
| orderable_type    | varchar   | 255       |           |           |               |
| orderable_id      | bigint    |           |           |           |               |
| user_id           | bigint    |           |           |           | 会员ID         |
| driver            | varchar   | 55        |           |           | 支付渠道        |
| gateway           | varchar   | 55        |           |           | 支付方法        |
| type              | varchar   | 55        |           | NULL      | 业务类型        |
| subject           | varchar   | 255       |           |           | 订单标题        |
| total_amount      | decimal   | 8,2       |           |           | 支付金额        |
| params            | json      |           | Y         | NULL      | 支付参数        |
| result            | json      |           | Y         | NULL      | 响应数据        |
| status            | tinyint   |           |           | 0         | 业务状态        |
| created_at        | timestamp |           | Y         | NULL      | 创建时间        |
| updated_at        | timestamp |           | Y         | NULL      | 更新时间        |
