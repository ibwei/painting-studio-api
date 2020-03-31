<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleComment extends Model
{

    //
    use SoftDeletes;

    protected $table = 'article_comment';
    protected $dates = ['deleted_at'];
}
