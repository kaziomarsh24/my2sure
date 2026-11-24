<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'name', 'ref_code', 'from_ref_code', 'email', 'password', 'type', 'expiry_date', 'isActive', 'trial_used', 'trial_used_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function forecaster()
    {
        return $this->hasMany('App\forecasterPlay', 'user_id', 'id'); //pivot Table
    }

    public function referralUsers()
    {
        return $this->hasMany(User::class, 'from_ref_code', 'ref_code');

    }
}
