<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tag;
use App\Models\view;
use App\Self\Alert;

class tagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags=tag::all();
        return view("admin.tags",compact(["tags"]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,["name"=>"required|min:2"],
        ['name.required'=>"این فیلد اجباری است",
          "name.min"=>"حداقل 2 کاراکتر"
        ]);

        $tag=new tag();
        $tag->name=$request->name;
        if($tag->save()){
            Alert::message("success","تگ با موفقیت افزوده شد","success")->show();
            return back();
        }else{
            Alert::message("error","!تگ افزوده نشد","error")->show();
            return back();
        }
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(tag $tag)
    {
        return view("admin.tag",compact(['tag']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,tag $tag)
    {
        $this->validate($request,['name'=>"required|min:2"],[
        "name.required"=>"این فیلد اجباری است",
        "name.min"=>"حداقل 2 کاراکتر"
        ]);

        $update_item=['name'=>$request->name];

        if($tag->update($update_item)){
            Alert::message("success","تگ با موفقیت ویرایش شد","success")->show();
            return redirect()->route("blog.tags");
        }else{
            Alert::message("error","تگ ویرایش نشد","error")->show();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(tag $tag)
    {
        $tag->article()->detach();
        $tag->delete();
        Alert::message("success","تگ با موفقیت حذف شد","success")->show();
        return back();
    }
}
