<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;
    protected $fillable=['name','description','pic'];


    public function products(){
        return $this->hasMany(product::class,"cat_id");
    }


//     array:5 [▼
//   "دسر" => array:1 [▼
//     "subcat_1" => array:1 [▼
//       "یه چیزی 7" => []
//     ]
//   ]
//   "کیک" => array:1 [▼
//     "subcat_2" => []
//   ]
//   "شیرینی تر" => []
//   "شیرینی خشک" => []
//   "لوازم تولد" => []
// ]
    public function getcats($parent_id){
        $cats=$this->where("parent_id",$parent_id)->where("maincat_id",2)->get();
        $catsTree=[];
        if(count($cats) > 0){
             foreach($cats as $cat){
                $catsTree[$cat->name]['subcat']=$this->getcats($cat->id);
                $catsTree[$cat->name]['id']=$cat->id;
             }
        }
        return $catsTree;
    }

}
