<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $table = "bank_accounts";
    protected $fillable = ['user_id','account_name','account_number','bank_name','status','created_at'];
    public $timestamps = false;
}


