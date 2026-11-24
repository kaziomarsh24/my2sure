<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialMediaLink extends Model
{
    protected $table = "social_media_links";
    protected $fillable = ['youtube','instagram','twitter','tiktok','linkedin','google','facebook','notification'];
    public $timestamps = false;
}
