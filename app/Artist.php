<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Tag;
use App\Category;
class Artist extends Model
{
    protected $tables = 'artists';
    protected $hidden = ['create_at', 'updated_at'];



    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
