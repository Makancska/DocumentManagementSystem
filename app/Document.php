<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    public $timestamps = false;

    protected $table = 'documents';

    protected $fillable = [
        "original_file_name",
        "version",
        "user_id",
        "name",
        "category_id",
        "file_path"
    ];
}
