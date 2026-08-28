<?php

namespace App\Http\Controllers;

use App\Models\article;
use App\Models\category;
use App\Models\tag;
use App\Models\view;
use App\Self\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Self\Helper;

class blogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($category = null)
    {   
        // $cats=category::where("maincat_id",1)->get();
        if($category==0){

            $articles=article::where("publish",1)->paginate(10);

        }else{
            $articles=article::where("cat_id",$category)->where('publish',1)->paginate(10);
            
        }
        return response()->json([    
        'articles'=>$articles->items(),
        'logPagination'=>$articles,
        'pagination'=>[
            'current_page'=>$articles->currentPage(),
            'last_page'=>$articles->lastPage(),
            'per_pager'=>$articles->perPage(),
            'total'=>$articles->total(), 
            ]
        ]);
    }

    public function adminIndex(){
        $articles=article::all();
        return view("admin.articles",compact(['articles']));
    }

    public function article(article $article){
        $tags=$article->tags;
        $cats=category::all();
        $relatedArticles=[];
        foreach ($tags as $tag){
            $relatedArticles=$tag->article;
        }

        return view("article",compact(['article',"tags","relatedArticles",'cats']));
    }


    public function getArticle($id){
        $article=new article();
        $result=$article->where('id',$id)->first();
        $tags=$result->tags;
        $relatedArticles=[];
        foreach ($tags as $tag){
            $relatedArticles=$tag->article;
        }

        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cats=DB::table('categories')->where('maincat_id',1)->get();
        $tags=tag::all();
        return view("admin.articleAdd",compact(['cats','tags']));
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
      $upload=$request->file('pic')->storeAs("public/articles",$filename);

      $article=new article();
      $article->cat_id=$request->cats_id;
      $article->title=$request->title;
      $article->slug=$slug;
      $article->pic=$filename;
      $article->content=$request->content;

      if($upload){
        if($article->save()){
            $article->tags()->sync($request->tags,false);
            Alert::message("success","مقاله با موفقیت ثبت شد","success")->show();
            return back();
        }else{
            Alert::message("error","مقاله ثبت نشد","error")->show();
            return back();
        }
      }
    

    }


    public function imgUploader(Request $request){
        $this->validate($request,["upload"=>"required|mimes:jpg,jpeg,png,tif,pdf"]);
        $fileName=$request->file("upload")->getClientOriginalName();
        $fileName=rand(0,1000).$fileName;
        $upload=$request->file("upload")->storeAs("public/articles",$fileName);
        
        echo json_encode([
            'default'=> asset("storage/articles/".$fileName),
            '500'=>asset("storage/articles/".$fileName)
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(article $article)
    {
        $tags=tag::all();
        $cats=category::where("maincat_id",1)->get();
        // dd($article);
       return view("admin.article",compact(['article','tags',"cats"]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(article $article)
    {
        if($article->publish==0){
            $update_items=['publish'=>1];
            $message="مقاله با موفقیت منشر شد";
        }else{
            $update_items=['publish'=>0];
            $message="انشار لغو شد";
        }

        if($article->update($update_items)){
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
    public function update(Request $request, article $article)
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
            $upload=$request->file('pic')->storeAs("public/articles",$filename);
            $update_items['pic']=$filename;
        }

        $update_items['title']=$request->title;
        $update_items['content']=$request->content;
        $update_items['slug']=$slug;
        $update_items['cat_id']=$request->cat_id;
        

        if($article->update($update_items)){
            $article->tags()->sync($request->tags,true);
            Alert::message("success","مقاله با موفقیت ویرایش شد","success")->show();
            return redirect()->route('article.show',$article);
        }else{
            Alert::message("error","مقاله ویرایش نشد","error")->show();
            return back();
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(article $article)
    {
        $article->delete();
        Alert::message("success","مقاله با موفقیت حذف شد","success")->show();
        return back();
    }
}
