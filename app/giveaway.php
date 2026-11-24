<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class giveaway extends Model
{
    //
     protected $table = "giveawayplan";
    protected $fillable = ['day', 'value'];
    public $timestamps = false;
}
