<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_detail extends Model
{
    use HasFactory;

    public function orders(){
        return $this->belongsTo(order::class);
    }

    public function products(){
        return $this->belongsTo(product::class);
    }
}
