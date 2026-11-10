<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $fillable = [
        'url',
        'url_hash',
        'icon',
        'title',
        'venue',
        'category',
        'description',
    ];
}
