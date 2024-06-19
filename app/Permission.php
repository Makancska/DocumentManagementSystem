<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $timestamps = false;

    protected $table = 'permissions';

    protected $fillable = [
        "user_id",
        "category_id",
        "can_download",
        "can_upload"
    ];
}
