<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $fillable = [
        'author_id', 'task_id', 'comment'
    ];

    public function author()
    {
        return $this->hasOne('App\Users','id','author_id');
    }
}
