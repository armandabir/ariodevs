<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\category;
use App\Models\view;
use App\Self\Alert;
use Illuminate\Support\Facades\DB;

class categoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexArticle()
    {
        $cats=DB::table("categories")->where("maincat_id",1)->get();
        return view("admin/articleCategory",compact(['cats']));
    }

       public function indexProject()
    {
        $cats=DB::table("categories")->where("maincat_id",3)->get();
        return view("admin.projects.projectCategory",compact(['cats']));
    }



    public function indexProduct(){
        $catTable= new category();
        $cats=$catTable->getcats(0);
        // dd($cats);

        return view("admin/productCategory",compact(['cats']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$cat,$parent_id)
    {


        $this->validate($request,["cat_name"=>"required|min:3"],
        ["cat_name.required"=>"فیلد اجباری است",
        "cat_name.min"=>"حداقل 3 کارکتر وارد کنید"
        ]);

        $cats_table=new category();
        
        if($request->maincat_id == 1 || $request->maincat_id == 3){
            $cats_table->parent_id=0;
        }else{
            $cats_table->parent_id=$request->cat_id;
        }
        

        if($request->hasFile('cat_pic')){
            $pic=$request->file("cat_pic");
            $filename=$pic->getClientOriginalName();
            $filename=rand(0,1000).$filename;
            $upload=$pic->storeAs("public/subcats",$filename);
            $cats_table->pic=$filename;
        }
        
        $cats_table->name=$request->cat_name;
        $cats_table->maincat_id=$request->maincat_id;
        $cats_table->description=$request->description;

        if($cats_table->save()){
            Alert::message("success","دسته با موفقیت ایجاد شد","success")->show();
            return back();
        }else{
            Alert::message("error","دسته ایجاد نشد","error")->show();
            return back();
        }
      
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function getcats($maincat){

        $cats=[];

        if($maincat==2){
            $productcat = new category();
            // $cats=$productcat->getcats(0);
            $cats=$productcat->where('maincat_id',$maincat)->where('parent_id',"!=","0")->get();
        }else{
             $cats=category::where('maincat_id',$maincat)->get();
        }

        return response()->json($cats);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,category $category)
    {
       
        $this->validate($request,['cat_name'=>"required|min:3"],[
            "cat_name.required"=>"این فیلد اجباری است",
            "cat_name.min"=>"حداقل 3 کاراکتر"
        ]);

        if($request->file("cat_pic")){
            $pic=$request->file("cat_pic");
            $filename=$pic->getClientOriginalName();
            $filename=rand(0,1000).$filename;
            $upload=$pic->storeAs("public/subcats",$filename);
            $cat_pic=$filename;
            $edit_item['pic']=$filename;
        }

        if($request->description!=null){
            
            $edit_item['description']=$request->description;
        }

        $edit_item['name']=$request->cat_name;

        $res=$category->update($edit_item);
        
        if($res){
            Alert::message("success","دسته با موفیقت ویرایش شد","success")->show();
            return back();
        }else{
            Alert::message("error","دسته ویرایش نشد","error")->show();
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $res=$category->delete();
        if($res){
            Alert::message("success","دسته با موفیقت حذف شد","success")->show();
            return back();
        }else{
            Alert::message("error","دسته حذف نشد","error")->show();
            return back();
        }
    }
}
