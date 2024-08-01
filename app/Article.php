<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;
    protected $fillable = ['id', 'content'];
    protected $dates = ['deleted_at'];
    protected $tables = 'articles';
    protected $hidden = ['create_at', 'updated_at'];

    public function images()
    {
        return $this->belongsTo(NGallery::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function getArtist()
    {
        return $this->hasOne(Artist::class, 'id', 'artist_id');
    }
    public function getCategory()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function getSubCategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'id');
    }
}
