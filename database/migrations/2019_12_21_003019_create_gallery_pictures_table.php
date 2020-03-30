<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleryPicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery_pictures', function (Blueprint $table) {
            $table->increments('id')->comment('递增ID,主键');
            $table->string('url', 100)->nullable(true)->comment('画廊图片的地址');
            $table->string('name', 50)->nullable(true)->comment('图片名称');
            $table->string('desc', 50)->nullable(true)->comment('图片所在画廊中方位介绍');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('statistics', function (Blueprint $table) {
            $table->increments('id')->comment('递增ID,主键');
            $table->dateTime('login_time')->nullable(true)->comment('登录时间');
            $table->dateTime('logout_time')->nullable(true)->comment('退出时间');
            $table->string('login_ip', 50)->nullable(true)->comment('登录Ip地址');
            $table->string('login_area', 20)->nullable(true)->comment('登录地区');
            $table->string('location', 50)->nullable(true)->comment('所在位置');
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
        Schema::dropIfExists('gallery_pictures');
        Schema::dropIfExists('statistics');
    }
}
