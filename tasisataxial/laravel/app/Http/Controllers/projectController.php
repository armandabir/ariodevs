<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\category;
use App\Models\project;
use App\Models\tag;
use App\Models\view;
use App\Self\Alert;
use Illuminate\Support\Facades\DB;
use App\Self\Helper;


class projectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function index($maincat = null , $cat = 0)
    {   
        // $cats=category::where("maincat_id",1)->get();
        $query = project::where('publish',1);
        
        if($cat !== null && $cat !=0 ){
            $query->where('cat_id',$cat);
        }
        $projects = $query->paginate();

        return response()->json([    
            'projects'=>$projects->items(),
            'logPagination'=>$projects,
            'pagination'=>[
                'current_page'=>$projects->currentPage(),
                'last_page'=>$projects->lastPage(),
                'per_pager'=>$projects->perPage(),
                'total'=>$projects->total(), 
                ]
            ]);
    }
        
    public function adminIndex(){
        $projects=project::all();
        return view("admin.projects.allprojects",compact(['projects']));
    }

    // public function project(project $project){
    //     $cats=category::all();
    //     // $tags=$article->tags;
    //     // $relatedArticles=[];
    //     // foreach ($tags as $tag){
    //     //     $relatedArticles=$tag->article;
    //     // }

    //     return view("admin.projects.project",compact(['project','cats']));
    // }


    public function getproject($id){
        $project=new project();
        $result=$project->where('id',$id)->first();
        
        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cats=DB::table('categories')->where('maincat_id',3)->get();
        // $tags=tag::all();
        return view("admin.projects.projectAdd",compact(['cats']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        $this->validate($request,['title'=>"required|min:3","pic"=>"required|mimes:jpg,jpeg,png,tif","content"=>"required|min:10"],
        ['name.required'=>"این فیلد اجباری است",
        'name.min'=>"حداقل 3 کاراکتر",
        'pic.required'=>"عکس مقاله اجباری است",
        'pic.mimes'=>"فرمت های مجاز:jpg,jpeg,png,tif",
        'content.required'=>'متن اجباری است',
        'content.min'=>"حداقل 10 کاراکتر"
            ]
        );

      $slug=Helper::sluggableCustomSlugMethod($request->title);
      $filename=$request->file("pic")->getClientOriginalName();
      $filename=rand(0,1000).$filename;
      $upload=$request->file('pic')->storeAs("public/projects",$filename);

      $project=new project();
      $project->cat_id=$request->cats_id;
      $project->title=$request->title;
      $project->slug=$slug;
      $project->pic=$filename;
      $project->content=$request->content;

      if($upload){
        if($project->save()){
          
            Alert::message("success","پروژه با موفقیت ثبت شد","success")->show();
            return back();
        }else{
            Alert::message("error","پروژه ثبت نشد","error")->show();
            return back();
        }
      }
    

    }


    public function imgUploader(Request $request){
        $this->validate($request,["upload"=>"required|mimes:jpg,jpeg,png,tif,pdf"]);
        $fileName=$request->file("upload")->getClientOriginalName();
        $fileName=rand(0,1000).$fileName;
        $upload=$request->file("upload")->storeAs("public/projects",$fileName);
        
        echo json_encode([
            'default'=> asset("storage/projects/".$fileName),
            '500'=>asset("storage/projects/".$fileName)
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(project $project)
    {
        // $tags=tag::all();
      $cats=category::where("maincat_id",3)->get();
        // dd($article);
       return view("admin.projects.project",compact(['project',"cats"]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function publish(project $project)
    {
        if($project->publish==0){
            $update_items=['publish'=>1];
            $message="پروژه با موفقیت منتشر شد";
        }else{
            $update_items=['publish'=>0];
            $message="انشار لغو شد";
        }

        if($project->update($update_items)){
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
    public function update(Request $request, project $project)
    {
        $this->validate($request,['title'=>"required|min:3","pic"=>"mimes:jpg,jpeg,png,tif","content"=>"required|min:10"],
        ['name.required'=>"این فیلد اجباری است",
        'name.min'=>"حداقل 3 کاراکتر",
        'pic.mimes'=>"فرمت های مجاز:jpg,jpeg,png,tif",
        'content.required'=>'متن اجباری است',
        'content.min'=>"حداقل 10 کاراکتر"
        ]
        );
        $update_items=[];
        $slug=Helper::sluggableCustomSlugMethod($request->title);
        if($request->pic){
            
            $filename=$request->file("pic")->getClientOriginalName();
            $filename=rand(0,1000).$filename;
            $upload=$request->file('pic')->storeAs("public/projects",$filename);
            $update_items['pic']=$filename;
        }

        $update_items['title']=$request->title;
        $update_items['content']=$request->content;
        $update_items['slug']=$slug;
        $update_items['cat_id']=$request->cat_id;
        

        if($project->update($update_items)){
            Alert::message("success","پروژه با موفقیت ویرایش شد","success")->show();
            return redirect()->route('project.show',$project);
        }else{
            Alert::message("error","پروژه ویرایش نشد","error")->show();
            return back();
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(project $project)
    {
        $project->delete();
        Alert::message("success","پروژه با موفقیت حذف شد","success")->show();
        return back();
    }
}
