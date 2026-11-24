<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class plans extends Model
{
    //
     protected $table = "plans";
    protected $fillable = ['name', 'sets','numbers','status'];
    public $timestamps = false;
}
