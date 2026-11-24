<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transactions extends Model
{

    public $timestamps =false;
    protected $table = "transactions";
    protected $primaryKey ="tid";
    protected $fillable = [
        'tid',
        'tranx_id',
        'user_id',
        'payment_amount',
        'payment_status',
        'order_id',
        'transaction_time',
        'payment_type'
    ];


    public function user(){

        return $this->belongsTo(User::class,'user_id','id');
    }
}
