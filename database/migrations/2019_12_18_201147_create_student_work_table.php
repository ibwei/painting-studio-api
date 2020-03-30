<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentWorkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_works', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('递增ID,主键');
            $table->string('url', 100)->nullable(false)->comment('学生作品图片url地址');
            $table->integer('order')->nullable(true)->default(0)->comment('轮播图的排序权重，越大越靠前');
            $table->string('name', 10)->nullable(true)->comment('学生姓名');
            $table->string('desc', 300)->nullable(true)->comment('作品介绍');
            $table->string('category', 100)->nullable(true)->comment('作品分类');
            $table->string('tags', 100)->nullable(true)->comment('作品标签');
            $table->integer('status')->nullable(false)->default(1)->comment('轮播图状态,状态 0:禁用,1:启用');
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
        Schema::dropIfExists('student_works');
    }
}
