<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class setting extends Model
{
    //
     protected $table = "settings";
    protected $fillable = ['name', 'details','created_at', 'updated_at'];
}
