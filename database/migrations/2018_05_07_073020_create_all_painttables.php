<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllPainttables  extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        //用户表
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('递增ID,主键');
            $table->string('name', 100)->nullable(false)->default('')->comment('用户名');
            $table->string('password', 64)->nullable(false)->default('')->comment('密码');
            $table->string('email', 32)->nullable(true)->default('')->comment('电子邮箱');
            $table->tinyInteger('gender')->unsigned()->nullable(true)->default(1)->comment('性别(1:男,2:女)');
            $table->string('avatar', 255)->nullable(true)->default('')->comment('用户头像');
            $table->string('phone', 50)->nullable(true)->default('')->comment('手机电话');
            $table->string('description', 400)->nullable(true)->default('')->comment('用户个人介绍');
            $table->integer('points')->nullable(true)->default(0)->comment('用户个人积分');
            $table->integer('vip')->nullable(true)->default(0)->comment('0:不是,1:是');
            $table->integer('device')->nullable(true)->default(0)->comment('用户注册设备,0:手机,1:电脑');
            $table->string('unionid', 50)->nullable(true)->default('')->comment('微信的unionid');
            $table->string('openid', 255)->nullable(true)->default('')->comment('用户唯一标识openid');
            $table->date('login_time')->nullable(true)->comment('记录用户最近一次登录时间');
            $table->tinyInteger('status')->default(1)->comment('0:禁用,1:正常');
            $table->tinyInteger('deleted')->default(0)->comment("软删除标记");
            $table->timestamps();
        });

        //画室表
        Schema::create('painting_studio', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('递增ID,主键');
            $table->string('name', 20)->nullable(true)->default('')->comment('画室名称');
            $table->string('logo', 100)->nullable(true)->default('')->comment('画室logo地址');
            $table->string('wechat', 20)->nullable(true)->default('')->comment('画室负责人微信id');
            $table->string('phone', 11)->nullable(true)->default('')->comment('画室联系号码');
            $table->string('qq', 11)->nullable(true)->default('')->comment('QQ号码');
            $table->string('email', 32)->nullable(true)->default('')->comment('画室电子邮箱');
            $table->string('er_code', 100)->nullable(true)->default('')->comment('负责人微信二维码');
            $table->string('address', 50)->nullable(true)->default('')->comment('画室所在地址');
            $table->string('address_location', 50)->nullable(true)->default('')->comment('画室地理位置经纬度 x,y');
            $table->tinyInteger('status')->nullable(false)->default(0)->comment('画室当前还在经营,状态 0:已关闭,1:在经营');
            $table->tinyInteger('deleted')->default(0)->comment("软删除标记");
            $table->timestamps();
        });

        //反馈表
        Schema::create('feedback', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('递增ID,主键');
            $table->string('name', 20)->nullable(false)->default('')->comment('反馈人姓名');
            $table->string('wechat', 20)->nullable(true)->default()->comment('微信id');
            $table->string('phone', 11)->nullable(false)->default('')->comment('联系号码');
            $table->string('email', 32)->nullable(true)->default('')->comment('反馈电子邮箱');
            $table->string('content', 300)->nullable(false)->default('')->comment('反馈内容');
            $table->string('result', 300)->nullable(true)->default('')->comment('处理结果');
            $table->integer('device')->nullable(true)->default(0)->comment('数据来源,0:手机,1:电脑');
            $table->integer('user_id')->nullable(true)->comment('处理人Id');
            $table->tinyInteger('status')->nullable(false)->default(0)->comment('反馈处理状态,状态 0:未处理,1:已处理');
            $table->tinyInteger('deleted')->default(0)->comment("软删除标记");
            $table->timestamps();
        });

        //课程表
        Schema::create('course_enroll', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('递增ID,主键');
            $table->string('name', 20)->nullable(false)->default('')->comment('反馈人姓名');
            $table->integer('user_id')->nullable(true)->comment('处理人Id');
            $table->string('email', 32)->nullable(true)->default('')->comment('反馈电子邮箱');
            $table->string('wechat', 20)->nullable(true)->default()->comment('微信id');
            $table->string('phone', 11)->nullable(false)->default('')->comment('联系号码');
            $table->integer('course_id')->nullable(true)->default()->comment('所报名的课程ID');
            $table->string('course_name',30)->nullable(true)->default()->comment('所报名的课程名称');
            $table->string('result', 300)->nullable(true)->default('')->comment('处理结果');
            $table->integer('device')->nullable(true)->default(0)->comment('数据来源,0:手机,1:电脑');
            $table->tinyInteger('status')->nullable(false)->default(0)->comment('反馈处理状态,状态 0:未处理,1:已处理');
            $table->tinyInteger('deleted')->default(0)->comment("软删除标记");
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
        Schema::drop('users');
        Schema::drop('feedback');
        Schema::drop('course_enroll');
        Schema::drop('painting_studio');
    }
}
