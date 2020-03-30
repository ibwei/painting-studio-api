<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Environment extends Model
{
    //
    use SoftDeletes;

    protected $table = 'environment';

    protected $dates = ['deleted_at'];
}
