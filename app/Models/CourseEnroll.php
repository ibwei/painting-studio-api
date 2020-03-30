<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseEnroll extends Model
{
    //
    use SoftDeletes;

    protected $table = 'course_enroll';

    protected $dates = ['deleted_at'];
}
