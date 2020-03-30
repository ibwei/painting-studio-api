<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentWorks extends Model
{
    //
    use SoftDeletes;

    protected $table = 'student_works';

    protected $dates = ['deleted_at'];
}
