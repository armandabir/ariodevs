<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class article extends Model
{
    use HasFactory;
    protected $fillable=['title','slug','content','pic','cat_id','publish'];
    public function tags(){
       return $this->belongsToMany('App\Models\tag');
    }

    public function getRouteKeyName()
    {
        
        return "slug";
        
    }
}
