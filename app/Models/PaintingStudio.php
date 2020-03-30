<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PaintingStudio extends Model
{
    //
    use SoftDeletes;

    protected $table = 'painting_studio';

    protected $dates = ['deleted_at'];
}
