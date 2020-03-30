<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePraiseEnviromentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('praise', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('递增ID,主键');
            $table->date('praise_time')->nullable(true)->comment('点赞日期');
            $table->string('login_ip', 50)->nullable(true)->comment('点赞Ip地址');
            $table->string('login_area', 60)->nullable(true)->comment('点赞地区');
            $table->string('location', 50)->nullable(true)->comment('点赞人位置');
            $table->string('device', 50)->nullable(true)->comment('登录设备类型');
            $table->string('brand', 50)->nullable(true)->comment('设备型号或者浏览器品牌');
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
        Schema::dropIfExists('praise');
    }
}
