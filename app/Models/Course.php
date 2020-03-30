<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    //
    use SoftDeletes;

    protected $table = 'course';
    protected $dates = ['deleted_at'];
}
