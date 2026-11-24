<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class plan_flags extends Model
{
    protected $table = "plan_flags";
    protected $primaryKey ='id';
    protected $fillable = ['id', 'sets','last_updated_plan_id','status'];
    public $timestamps = false;
}
