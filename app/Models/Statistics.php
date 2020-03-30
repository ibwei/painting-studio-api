<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Statistics extends Model
{
    //
    use SoftDeletes;

    protected $table = 'statistics';

    protected $dates = ['deleted_at'];
}
