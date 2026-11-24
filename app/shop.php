<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class shop extends Model
{
    protected $table = "shop";
    protected $fillable = ['name','description','price','logo'];
    public $timestamps = false;



}
