@extends('layouts.master-adminDashboard')

@section('page',"دسته های محصولات")


@section('content')
<section class="content">
    <div class="container">
{{--@foreach($cats as $key=>$cat)
     @php
        print($key)
    @endphp

   @foreach($cat as $subkey=>$subcat)
    @php
        print($subkey)
    @endphp
    @endforeach
 @endforeach--}}
        <div class="row">
            <div class="col-md-6 mx-auto">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="maincat_id" value="2">
                        <select name="cat_id" id="" class="form-control">
                            <option selected="selected">دسته را انتخاب کنید</option>
                            <option value="0" data-parent_id="0" data-cat="new">دسته جدید</option>
                            @foreach($cats as $key=>$cat)
                                <option value="{{$cat['id']}}" data-parent_id="0" data-cat="{{$cat['id']}}">{{$key}}</option>
                                @if(count($cat['subcat'])>0)
                                    @foreach($cat['subcat'] as $subkey=>$subcat)
                                     <option value="{{$subcat['id']}}" data-parent_id="{{$cat['id']}}" data-cat="{{$subcat['id']}}">---{{$subkey}}</option>
                                    @endforeach
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cat_name">نام دسته</label>
                        <input type="text" class="form-control @error('cat_name') is-invalid @enderror" name="cat_name" id="cat_name" value="{{old('cat_name')}}">
                        @error('cat_name')
                            <strong class="invalid-feedback">
                                {{$message}}
                            </strong>
                        @enderror
                        
                    </div>

                    <div class="form-group">
                        <label for="editor">متن</label>
                        <textarea name="description" id="editor" class="form-control @error('content') is-invalid @enderror" cols="30" rows="10">{{old('content')}}</textarea>
                        @error('content')
                            <strong class="invalid-feedback">
                                {{$message}}
                            </strong>
                        @enderror
                    </div>

                    <div class="form-group">
                      <label for="cat_pic">عکس دسته</label>
                      <input type="file" class="form-control @error('cat_pic') is-invalid @enderror" name="cat_pic" id="cat_pic" value="">
                        @error('cat_pic')
                            <strong class="invalid-feedback">
                                {{$message}}
                            </strong>
                        @enderror
                    </div>


                    <div class="form-group">
                         <div class="row">
                            <div class="col-md-4">
                                <input type="submit" class="btn btn-primary btn-block" data-action="create" name="submit" value="جدید">
                            </div>

                            <div class="col-md-4">
                                <input type="submit" class="btn btn-success btn-block" data-action="edit" name="submit" value="ویرایش">

                            </div>

                            <div class="col-md-4">
                                <input type="submit" class="btn btn-danger btn-block" data-action="delete" name="submit" value="حذف">

                            </div>
                         </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>
@if(session()->has('string'))
    @include('layouts.alert')

@endif

<script>
    $(document).ready(function(){
        $('form').trigger("reset");
    })


    var cat="";
    let parent_id=""
    $("select option").on("click",function(){
       cat=$(this).attr('data-cat');
       parent_id=$(this).attr('data-parent_id')
       console.log(parent_id)
    })

    $("input[type='submit']").on("click",function(event){
        // event.preventDefault();
        var action=$(this).attr('data-action');
       if(parent_id>0 && action=="create"){

        event.preventDefault();
                Swal.fire({
                    icon:"error",
                    text:"امکان ایجاد دسته زیرمجموعه برای این دسته نیست",
                    confirmButtonText:'باشه'
                })

       }else{

        if(cat!=""){
                var url="{{route('cats.create',['cats'=>':cat','parent_id'=>':parent_id'])}}"
      
                url=url.replace('create',action);
                url=url.replace(':cat',cat);
                url=url.replace(':parent_id',parent_id)
                $("form").attr("action",url);
            }else{
                event.preventDefault();
                Swal.fire({
                    icon:"error",
                    text:"یک دسته را انتخاب کنید",
                    confirmButtonText:'باشه'
                })
            }
         

       }

    
       

       

    })
</script>

@endsection