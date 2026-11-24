<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class lottery extends Model
{
    //
    protected $table = "lotteries";
    protected $fillable = ['game_id', 'name', 'permutation', 'starting_no', 'one_time' , 'sets', 'status', 'plays', 'created_at', 'updated_at'];

    public function game()
    {
        return $this->hasOne('App\games', 'id', 'game_id');
    }

    public function getStatusAttribute($value)
    {
    	if($value==1)
    	{
    		return "Active";
    	}else
    	{
    		return "In-Active";
    	}
    }
} 