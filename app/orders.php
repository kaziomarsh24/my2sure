<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    public $timestamps= false;
    protected $table ="orders";
    protected $fillable=[
        'user_id',
        'product_id',
        'variant_id',
        'quantity',
        'total_amount',
        'payment_id',
        'created_at'
    ];
    public function user(){

        return $this->belongsTo(User::class,'user_id','id');
    }
    public function product(){

        return $this->belongsTo(shop::class,'product_id','id');
    }

    public function variant(){

        return $this->belongsTo(variant::class,'variant_id','id');
    }
}
