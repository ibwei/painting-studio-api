<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('递增ID,主键');
            $table->string('name', 20)->nullable(true)->comment('老师姓名');
            $table->string('photo',100)->nullable(true)->comment('照片');
            $table->integer('rate')->nullable(true)->comment('评价分数');
            $table->string('desc', 50)->nullable(true)->comment('老师简介');
            $table->string('deeds', 50)->nullable(true)->comment('老师奖项（获奖内容）');
            $table->string('impression', 50)->nullable(true)->comment('学生对老师的印象以-分隔');
            $table->string('good_at')->nullable(false)->comment('擅长标签以-分隔');
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
        Schema::dropIfExists('teacher');
    }
}
