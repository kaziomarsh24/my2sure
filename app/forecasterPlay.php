<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class forecasterPlay extends Model
{
    //
    protected $table = "forecaster_plays";
    protected $fillable = ['user_id', 'game_name','lottery_id', 'numbers' ];

    public function lottery()
    {
        return $this->hasOne('App\lottery', 'id', 'lottery_id');
    }
    public function user()
    {
        return $this->hasOne('App\user', 'id', 'user_id');
    }


}
