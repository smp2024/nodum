<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Project extends Model
{
    protected $fillable = ['id', 'content'];
    protected $tables = 'projects';
    protected $hidden = ['create_at', 'updated_at'];

    public function descriptions() {
        return $this->belongsTo(Description::class);
    }

    public function images() {
        return $this->belongsTo(NGallery::class);
    }
}
