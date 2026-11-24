<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class games extends Model
{
    //
    protected $fillable = ['name', 'details', 'status', 'end_date' , 'created_at', 'updated_at', 'logo'];

    public function lottery()
    {
        return $this->hasMany('App\lottery', 'game_id');
    }

    public function getStatusAttribute($val)
    {
    	if($val == 1)
    	{
    		return "Active";
    	}else
    	{
    		return "In-Active";

    	}
    }
}
