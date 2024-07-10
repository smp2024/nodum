<?php

namespace App;
use App\Article;
use App\Category;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $tables = 'tags';
    protected $hidden = ['create_at', 'updated_at'];


    public function getArticles()
    {
        return $this->belongsToMany(Article::class);
    }
    public function getCategories()
    {
        return $this->belongsToMany(Category::class);
    }
}
