<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Praise extends Model
{
    use SoftDeletes;

    protected $table = 'praise';
    protected $dates = ['deleted_at'];
}
