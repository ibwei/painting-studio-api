<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTwoCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_comment', function (Blueprint $table) {
            $table->increments('id')->comment('递增ID,主键');
            $table->integer('teacher_id')->nullable(false)->comment('教师ID');
            $table->integer('user_id')->nullable(false)->comment('评论用户ID');
            $table->integer('level')->nullable(false)->default(0)->comment('评论层级');
            $table->string('content', 300)->nullable(true)->comment('评论内容');
            $table->integer('parent_id')->nullable(false)->default(0)->comment('回复的评论ID');
            $table->integer('star')->nullable(false)->default(5)->comment('五星好评分数');
            $table->integer('status')->nullable(false)->default(0)->comment('评论是否通过审核,状态 0:禁用,1:启用');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('article_comment', function (Blueprint $table) {
            $table->increments('id')->comment('递增ID,主键');
            $table->integer('article_id')->nullable(false)->comment('文章ID');
            $table->integer('user_id')->nullable(false)->comment('评论用户ID');
            $table->integer('level')->nullable(false)->default(0)->comment('评论层级');
            $table->integer('parent_id')->nullable(false)->default(0)->comment('回复的评论ID');
            $table->string('content', 300)->nullable(true)->comment('评论内容');
            $table->integer('status')->nullable(false)->default(0)->comment('评论是否通过审核,状态 0:禁用,1:启用');
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
        Schema::dropIfExists('teacher_comment');
        Schema::dropIfExists('article_comment');
    }
}
