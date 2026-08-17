<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    protected $fillable=["name","slug","pic","price","content","publish","cat_id"];

    public function getRouteKeyName()
    {
        
        return "slug";
        
    }

    public function subcat(){
        return $this->belongsTo('App\Models\category',"cat_id");
    }

    public function tags(){
        return $this->belongsToMany('App\Models\tag');
     }
 
}
