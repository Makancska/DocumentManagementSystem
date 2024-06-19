<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'parent_id'
    ];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function files()
    {
        return $this->hasMany(Document::class);
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
