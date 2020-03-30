<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourselTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coursel', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('递增ID,主键');
            $table->string('url', 100)->nullable(false)->comment('轮播图的地址');
            $table->integer('order')->nullable(true)->default(0)->comment('轮播图的排序权重，越大越靠前');
            $table->string('routerUrl', 100)->nullable(true)->comment('需要题跳转的url');
            $table->string('desc', 50)->nullable(true)->comment('轮播图介绍');
            $table->integer('status')->nullable(false)->default(0)->comment('轮播图状态,状态 0:禁用,1:启用');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coursel');
    }
}
