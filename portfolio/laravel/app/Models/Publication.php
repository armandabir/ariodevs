<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'url_hash',
        'icon',
        'title',
        'venue',
        'category',
        'description',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function translations()
    {
        return $this->hasMany(PublicationTranslation::class);
    }
}
