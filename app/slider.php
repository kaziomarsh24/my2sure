<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use KaziOmar\SmartUpload\Traits\HasUploadPurge;

class slider extends Model
{
    use HasUploadPurge;

    protected $table = "slider";
    public $timestamps = false;
    protected $fillable = ['id', 'image', 'link'];

    /** @var array<string> */
    protected array $purgeableFiles = ['image'];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('global_sliders'));
        static::deleted(fn () => Cache::forget('global_sliders'));
    }
}
