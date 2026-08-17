<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\page;
use App\Models\view;
use App\Self\Alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    //API

    public function listItems($page_id,$sect_id){
        $items=page::where('page_id',$page_id)->where('sect_id',$sect_id)->get();
        return response()->json($items);

    }

    // 

    public function create($page_id,$sect_id){

            switch ($page_id) {
                case 1:
                    if($sect_id==1){
                        $page=page::where('page_id',$page_id)->where('sect_id',$sect_id)->first();
                        return view("admin.pages.mainpage.slider",compact(['page']));
                    }

                    if($sect_id==2){
                         return view("admin.pages.mainpage.engservices",compact(['page_id','sect_id']));
                    }

                      if($sect_id==3){
                         return view("admin.pages.branches.createBranch",compact(['page_id','sect_id']));
                    }

                    break;
               
                case 2:
                     return view("admin.pages.services.service",compact(['page_id','sect_id']));
                    
                    break;
               case 3:
                    if($sect_id==1){
                        return view("admin.pages.contact.intro",compact(['page_id','sect_id']));
                    }

                     if($sect_id==2){
                        return view("admin.pages.contact.features",compact(['page_id','sect_id']));
                    }

                     if($sect_id==3){
                         return view("admin.pages.contact.mission",compact(['page_id','sect_id']));
                    }

                    if($sect_id==4){
                         return view("admin.pages.contact.goals",compact(['page_id','sect_id']));
                    }

                    if($sect_id==5){
                        
                    }
                    break;
                default:
                    # code...
                    break;
            }
    }


    public function show($page_id,$sect_id){
       
       $items=page::where('page_id',$page_id)->where('sect_id',$sect_id)->get();
       if(count($items)==0){
        Alert::message("error","ایتمی برای ویرایش وجود ندارد",'error')->show();
        return redirect()->route('admin.home',[$page_id,$sect_id]);
       }

        return view('admin.pages.show',compact(['items']));

    }





    public function store(Request $request,$page_id,$sect_id){

        $this->validate($request,['pic.*'=>"mimes:jpg,jpeg,png,tif"],[
            'pic.mimes'=>"فرمت های مجاز:jpg,jpeg,png,tif",
            
            'desc.min'=>"حداقل 10 کاراکتر",
        ]);

        if($request->filled('title')){
           $this->validate($request,['title'=>'min:3'],['title.min'=>"حداقل 3 کاراکتر",]);
        }

    
        if($request->filled('desc')){
             $this->validate($request,['desc'=>'min:10'],['desc.min'=>"حداقل 10 کاراکتر",]);
        }

        $page = new page();
        
        if($request->has('pic')){

               if(is_array($request->pic)){
                    
                    $pics=[];
                    foreach($request->file("pic") as $pic ){
                        $filename=$pic->getClientOriginalName();
                        $filename=rand(0,1000).$filename;
                        $upload=$pic->storeAs("public/pages",$filename);
                        $pics[]=$filename;
                    }
                    $page->pic=json_encode($pics);
                
                }else{

                    $filename=$request->file('pic')->getClientOriginalName();
                    $filename=rand(0,1000).$filename;
                    $upload=$request->file('pic')->storeAs("public/pages",$filename);   
                    $page->pic=$filename;
                }
          
        }


       
            

        if($request->has('checkcount')){
            $limit=$request->checkcount;
            $pageitem=page::where('page_id',$page_id)->where('sect_id',$sect_id)->get();
            if(count($pageitem) >= $limit){
                Alert::message('error','تعداد ایتم های مجاز '. $limit . 'می باشد','error')->show();
                return back();
            };
        }


        
   
        $page->page_id=$page_id;
        $page->sect_id=$sect_id;
        $page->title=$request->title;
        $page->sect_name=$request->sect_name;
        $page->desc=$request->desc;

        if($page->save()){
            Alert::message('succcess','آیتم با موفقیت ثیت شد ','success')->show();
            
        }else{
            Alert::message('error','خطا در ثبت','error')->show();
        }

        return back();
        
        
    }


    public function edit(Page $page){
        $item=$page;    
        return view('admin.pages.edit',compact(['item']));
        
    }

    public function update(Request $request,Page $page){

 

           if($request->hasFile('pic')){
                $this->validate($request,["pic.*"=>"mimes:jpg,jpeg,png,tif"],[
                    'pic.*.mimes'=>"فرمت های مجاز:jpg,jpeg,png,tif",
                ]);
            
            
            $update_items=[]; 

            $updatedPics=json_decode($page->pic,true);
                if(is_array($updatedPics)){
                    
                    foreach ($request->file('pic') as $key=>$pic){

                        $filename=$pic->getClientOriginalName();
                        $filename=rand(0,1000).$filename;
                        $upload=$pic->storeAs("public/pages",$filename);   
                        $updatedPics[$key]=$filename;
                    }
                    

                    $update_items['pic']=json_encode($updatedPics);
 
                }else{

                    $filename=$request->file('pic')->getClientOriginalName();
                    $filename=rand(0,1000).$filename;
                    $upload=$request->file('pic')->storeAs("public/pages",$filename);   
                    $update_items['pic']=$filename;
                }
        }

        if($request->filled('title')){
           $this->validate($request,['title'=>'min:3'],['title.min'=>"حداقل 3 کاراکتر",]);
           $update_items['title']=$request->title;
        }

    
        if($request->filled('desc')){
             $this->validate($request,['desc'=>'min:10'],['desc.min'=>"حداقل 10 کاراکتر",]);
             $update_items['desc']=$request->desc;
        }

        $result=$page->update($update_items);

        if($result){

            Alert::message('succcess','آیتم با موفقیت ویرایش شد ','success')->show();
            }else{
            Alert::message('error','خطا در ویرایش','error')->show();
        }


        return back();
    }


    public function destroy(page $page){

        if($page->delete()){
          Alert::message('succcess','آیتم با موفقیت حذف شد ','success')->show();
        }else{
          Alert::message('error','خطا در حذف','error')->show();
        };

        return back();
    }


    public function session(){
        // if(session()->has('string')){

        //     return response()->json(['has'=>true,'msg'=>session('string')]);
        // }else{
        //    return response()->json(['has'=>false,'msg'=>null]);
        // }
        return response()->json(session()->all());
    }
}
