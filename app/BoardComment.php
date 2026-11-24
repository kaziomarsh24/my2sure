<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoardComment extends Model
{
    protected $table = 'board_comments';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(BoardComment::class, 'parent_id')
            ->orderBy('id', 'ASC');
    }

    public function post()
    {
        return $this->belongsTo(BoardPost::class, 'post_id');
    }
}
