<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicationTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'publication_id',
        'locale',
        'title',
        'venue',
        'category',
        'description',
        'status',
    ];

    public function publication()
    {
        return $this->belongsTo(Publication::class);
    }
}
