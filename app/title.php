<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class title extends Model
{
    //
     protected $table = "title";
    protected $fillable = ['result_section'];
    public $timestamps = false;
}
