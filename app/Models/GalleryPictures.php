<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GalleryPictures extends Model
{
    //
    use SoftDeletes;

    protected $table = 'gallery_pictures';

    protected $dates = ['deleted_at'];
}
