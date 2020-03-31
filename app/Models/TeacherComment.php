<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherComment extends Model
{

    //
    use SoftDeletes;

    protected $table = 'teacher_comment';
    protected $dates = ['deleted_at'];
}