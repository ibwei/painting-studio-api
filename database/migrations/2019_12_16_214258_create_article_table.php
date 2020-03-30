<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            //课程表
            $table->bigIncrements('id')->comment('递增ID,主键');
            $table->integer('user_id')->nullable(false)->comment('发表文章的管理员ID');
            $table->string('title', 50)->nullable(false)->comment('文章标题');
            $table->longText('content')->nullable(true)->comment('文章内容');
            $table->string('tags', 50)->nullable(false)->default('')->comment('文章标签,多个标签-分隔');
            $table->string('category', 50)->nullable(false)->default('')->comment('文章分类,对应前台的标签');
            $table->string('thumbnail',500)->nullable(true)->default()->comment('文章缩略图或者缩略图列表');
            $table->integer('praise_count')->nullable(true)->default(0)->comment('文章点赞量');
            $table->integer('read_count')->nullable(true)->default(0)->comment('文章阅读量');
            $table->integer('comment_count')->nullable(true)->default(0)->comment('文章评论数');
            $table->integer('read_device')->nullable(true)->default(0)->comment('查看文章入口来源,0:手机,1:电脑');
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
        Schema::dropIfExists('article');
    }
}
