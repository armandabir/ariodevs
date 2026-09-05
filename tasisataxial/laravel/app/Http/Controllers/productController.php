<?php

namespace App\Http\Controllers;

use App\Models\view;
use Illuminate\Http\Request;
use App\Models\category;
use App\Models\product;
use App\Models\tag;
use App\Self\Helper;
use App\Self\Alert;

class productController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($maincat = null , $cat = 0)
    {
   
        $query = product::where('publish',1);
        
        if($cat !== null && $cat !=0 ){
            $query->where('cat_id',$cat);
            }
            
        $product=$query->paginate(6);
        
        // $cats=category::where("maincat_id",1)->get();
        // if($category==0){

        //     $articles=article::where("publish",1)->paginate(10);

        // }else{
        //     $articles=article::where("cat_id",$category)->where('publish',1)->paginate(10);
            
        // }
        return response()->json([    
        'articles'=>$product->items(),
        'logPagination'=>$product,
        'pagination'=>[
            'current_page'=>$product->currentPage(),
            'last_page'=>$product->lastPage(),
            'per_pager'=>$product->perPage(),
            'total'=>$product->total(), 
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $catTable= new category();
        $cats=$catTable->getcats(0);
        $tags=Tag::all();
       return view("admin.productAdd",compact(['cats','tags']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,['title'=>"required|min:3","content"=>"required|min:10","price"=>"required|numeric|min:4"],
        ['title.required'=>"این فیلد اجباری است",
        'title.min'=>"حداقل 3 کاراکتر",
        'content.required'=>'متن اجباری است',
        'content.min'=>"حداقل 10 کاراکتر",
        'price.required'=>'این فیلد اجباری است',
        'price.numeric'=>"مقدار، عددی باشد",
        'price.min'=>"حداقدل 4 رقم باشد"
            ]
        );

        $this->validate($request,["pic"=>"required|array|min:2","pic.*"=>"required|mimes:jpg,jpeg,png,tif"],[
            'pic.required'=>"عکس محصول اجباری است",
            'pic.*.mimes'=>"فرمت های مجاز:jpg,jpeg,png,tif",
            'pic.min'=>'حداقل 2 عکس انتخاب کنید'
        ]);

        
      $slug=Helper::sluggableCustomSlugMethod($request->title);

      $pics=[];
        foreach($request->file("pic") as $pic ){
            $filename=$pic->getClientOriginalName();
            $filename=rand(0,1000).$filename;
            $upload=$pic->storeAs("public/products",$filename);
            $pics[]=$filename;
        }


        $product=new product();
        $product->cat_id=$request->cat_id;
        $product->name=$request->title;
        $product->slug=$slug;
        $product->pic=json_encode($pics);
        $product->content=$request->content;
        $product->price=$request->price;

      if($upload){
        if($product->save()){
            $product->tags()->sync($request->tags,false);
            Alert::message("success","محصول با موفقیت ثبت شد","success")->show();
            return back();
        }else{
            Alert::message("error","محصول ثبت نشد","error")->show();
            return back();
        }
      }
    
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        $allcats = new category;
        $cats=$allcats->getcats(0);
        $tags=$product->tags()->get();
        $productcat=$product->subcat()->first();
        return view("admin.product",compact(['product','cats','tags','productcat']));
    }


    public function getProduct($id){
        $product=product::where("id",$id)->first();
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $products=product::all();
        return view("admin.products",compact(['products']));
    }


    public function publish(product $product){
        if($product->publish==0){
            $update_items=['publish'=>1];
            $message="محصول با موفقیت منشر شد";
        }else{
            $update_items=['publish'=>0];
            $message="انشار لغو شد";
        }

        if($product->update($update_items)){
            Alert::message("success",$message,"success")->show();
            return back();
        }else{
            Alert::message("error","عملیات شکست خورد","error")->show();
            return back();
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, product $product)
    {
                $this->validate($request,['title'=>"required|min:3","content"=>"required|min:10","price"=>"required|numeric|min:4"],
        ['title.required'=>"این فیلد اجباری است",
        'title.min'=>"حداقل 3 کاراکتر",
        'content.required'=>'متن اجباری است',
        'content.min'=>"حداقل 10 کاراکتر",
        'price.required'=>'این فیلد اجباری است',
        'price.numeric'=>"مقدار، عددی باشد",
        'price.min'=>"حداقدل 4 رقم باشد"
            ]
        );
        
            if($request->hasFile('pic')){
                $this->validate($request,["pic.*"=>"required|mimes:jpg,jpeg,png,tif"],[
                    'pic.*.mimes'=>"فرمت های مجاز:jpg,jpeg,png,tif",
                ]);
            
            
            $update_items=[]; 

            $updatedPics=json_decode($product->pic);
            
            foreach ($request->file('pic') as $key=>$pic){
                // dd($key);
                $filename=$pic->getClientOriginalName();
                $filename=rand(0,1000).$filename;
                $upload=$pic->storeAs("public/products",$filename);
                $updatedPics[$key]=$filename;
            }
            

            $update_items['pic']=json_encode($updatedPics);
           
        }
        
        
        $slug=Helper::sluggableCustomSlugMethod($request->title);

        $update_items['name']=$request->title;
        $update_items['slug']=$slug;
        $update_items['price']=$request->price;
        $update_items['content']=$request->content;

        
            if($product->update($update_items)){
                Alert::message("success","محصول با موفقیت ویرایش شد","success")->show();
                return back();
            }else{
                Alert::message("error","خطا در ویرایش","error")->show();
                return back();
            }
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(product $product)
    {
        //
    }
}
