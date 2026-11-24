<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'subscriptions';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function isActive($userId, $type)
    {
        return self::where('user_id', $userId)
            ->where('type', $type)
            ->where('status', 'active')
            ->where('expires_at', '>=', date('Y-m-d'))
            ->exists();
    }
}
