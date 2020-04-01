<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookSchedule extends Model
{
    //
    use SoftDeletes;

    protected $table = 'book_schedule';
    protected $dates = ['deleted_at'];
}
