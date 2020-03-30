<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course', function (Blueprint $table) {
            $table->increments('id')->comment('递增ID,主键');
            $table->string('url', 100)->nullable(true)->comment('课程图片');
            $table->string('name', 50)->nullable(true)->comment('课程名称');
            $table->integer('order')->nullable(false)->default(0)->comment('课程排序权重，越大越靠前');
            $table->string('category', 100)->nullable(true)->comment('课程的一级分类名称');
            $table->string('subCategory', 100)->nullable(true)->comment('课程的二级分类名称');
            $table->string('tags', 100)->nullable(true)->comment('课程标签');
            $table->string('desc', 50)->nullable(true)->comment('课程介绍');
            $table->string('tuition', 50)->nullable(true)->comment('学费');
            $table->date('valid_time')->nullable(true)->comment('课程有效时间');
            $table->string('teacher')->nullable(true)->comment('课程教师');
            $table->integer('status')->nullable(false)->default(1)->comment('课程是否可用,状态 0:禁用,1:启用');
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
        Schema::dropIfExists('course');
    }
}
