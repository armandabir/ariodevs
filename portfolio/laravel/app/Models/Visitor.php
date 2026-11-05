<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'token', 'ip', 'country', 'city', 'timezone', 'timezone_name', 'ip_timezone', 'vpn_suspected', 'visits', 'last_seen_at',
    ];

    protected $casts = ['last_seen_at' => 'datetime', 'vpn_suspected' => 'boolean'];

    // Converts e.g. "Asia/Tehran" to "Tehran, Asia".
    public static function readableTimezone(?string $timezone): ?string
    {
        if (! $timezone) {
            return null;
        }

        $parts = explode('/', $timezone);

        return str_replace('_', ' ', count($parts) > 1 ? end($parts).', '.$parts[0] : $parts[0]);
    }
}
