<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule', function (Blueprint $table) {
            $table->increments('id')->comment('递增ID,主键');
            $table->integer('day')->nullable(false)->comment('星期几，0:星期日，1:星期一,以此类推');
            $table->integer('time')->nullable(false)->comment('am:上午,pm:下午,night:晚上');
            $table->integer('status')->nullable(false)->default(1)->comment('上午是否上课,0:不上,1:上课,2：预约,3:放假');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('book_schedule', function (Blueprint $table) {
            $table->increments('id')->comment('递增ID,主键');
            $table->integer('user_id')->nullable(false)->comment('预约用户ID');
            $table->integer('schedule_id')->nullable(false)->comment('预约课程ID');
            $table->integer('status')->nullable(false)->default(0)->comment('评论是否通过审核,状态 0:待审核,1:预约成功,预约失败');
            $table->softDeletes();
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
        Schema::dropIfExists('book_course');
    }
}
