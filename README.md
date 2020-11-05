**支付管理**

引用库
 
 [yansongda/laravel-pay](https://github.com/yansongda/laravel-pay)
 扫码土又[simplesoftwareio/simple-qrcode](https://github.com/SimpleSoftwareIO/simple-qrcode)

##安装：
```
composer require jncinet/qihucms-payment
```

###第一步：创建表
```
php artisan migrate
```

###第二步：添加后台管理菜单
```
payment/pay-orders
```

##使用
```php
创建订单时，先创建支付订单记录：
PayOrder::create([
...
]);
```
目录说明
```
支付目录：payment/pay/{$id}
支付回调：payment/{driver}/notify
支付完成：payment/completed
```