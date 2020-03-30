<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnvironmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('environment', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('递增ID,主键');
            $table->string('url', 100)->nullable(false)->comment('教室环境图片url地址');
            $table->integer('order')->nullable(true)->default(0)->comment('教室环境的排序权重，越大越靠前');
            $table->string('desc', 300)->nullable(true)->comment('教室环境介绍');
            $table->integer('status')->nullable(false)->default(1)->comment('教室环境状态,状态 0:禁用,1:启用');
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
        Schema::dropIfExists('environment');
    }
}
