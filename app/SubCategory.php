<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SubCategory extends Model
{
    //use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    protected $tables = 'sub_categories';
    protected $hidden = ['create_at', 'updated_at'];


    public function images() {
        return $this->belongsTo(NGallery::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function getCategory()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
