<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Stripe\Product;

class variant extends Model
{
    protected $table = "variants";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable=[
        'id',
        'product_id',
        'label',
        'stock',
        'sold',
        'created_at'
    ];

    public function product(){

        return $this->belongsTo(product::class,'product_fk','id');

    }
}
