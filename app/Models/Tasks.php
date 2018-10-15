<?php

namespace App;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $fillable = [
        'assignee_id', 'title', 'description'
    ];

    public function comments()
    {
        return $this->hasMany('App\Comments','task_id');
    }

    public function assignee()
    {
        return $this->hasOne('App\Users','id','assignee_id');
    }

    public function scopeFilter($query, $request)
    {
        $filter = $request->get('filter');

        if(isset($filter['assignee_id'])) $query->where('assignee_id', $filter['assignee_id']);
        if(isset($filter['title'])) $query->where('title','like',"%{$filter['title']}%");

        return $query;
    }
}
