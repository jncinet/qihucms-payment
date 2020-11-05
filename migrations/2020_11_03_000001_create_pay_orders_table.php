<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('orderable');
            $table->unsignedBigInteger('user_id')->index()->comment('会员ID');
            $table->string('driver', 55)->comment('支付渠道');
            $table->string('gateway', 55)->comment('支付方法');
            $table->string('type', 55)->comment('业务类型');
            $table->string('subject')->comment('订单标题');
            $table->unsignedDecimal('total_amount')->comment('支付金额');
            $table->json('params')->nullable()->comment('支付参数');
            $table->json('result')->nullable()->comment('响应数据');
            $table->boolean('status')->default(0)->comment('业务状态');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pay_orders');
    }
}
