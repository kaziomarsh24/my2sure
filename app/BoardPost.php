<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoardPost extends Model
{
    protected $table = 'board_posts';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(BoardComment::class, 'post_id')
            ->whereNull('parent_id')
            ->orderBy('id', 'DESC');
    }
}
