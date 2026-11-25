<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use KaziOmar\SmartUpload\Traits\HasUploadPurge;

class shop extends Model
{
    use HasUploadPurge;

    protected $table = "shop";
    protected $fillable = ['name', 'description', 'price', 'logo'];
    public $timestamps = false;

    /** @var array<string> */
    protected array $purgeableFiles = ['logo'];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('shop_products'));
        static::deleted(fn () => Cache::forget('shop_products'));
    }
}
