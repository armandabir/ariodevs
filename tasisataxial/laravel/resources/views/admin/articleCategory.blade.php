@extends('layouts.master-adminDashboard')

@section('page',"دسته ها")


@section('content')
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="maincat_id" value="1">
                        <select name="cat_id" id="" class="form-control">
                            <option selected="selected">دسته را انتخاب کنید</option>
                            <option value="0" data-cat="new">دسته جدید</option>
                            @foreach($cats as $cat)
                                <option value="{{$cat->id}}" data-cat="{{$cat->id}}">{{$cat->name}}</option>
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
    let parent_id;

    $("select option").on("click",function(){
       cat=$(this).attr('data-cat');
       parent_id=0;
       console.log($(this).val())
    })

    $("input[type='submit']").on("click",function(event){
        // event.preventDefault();
       

        if(cat!=""){
            var url="{{route('cats.create',['cats'=>':cat','parent_id'=>':parent_id'])}}"
            var action=$(this).attr('data-action');
            url=url.replace('create',action);
            url=url.replace(':cat',cat);
            url=url.replace(':parent_id',parent_id)
            $("form").attr("action",url);
            console.log(url);
        }else{
            event.preventDefault();
            Swal.fire({
                icon:"error",
                text:"یک دسته را انتخاب کنید",
                confirmButtonText:'باشه'
            })
        }
       

       

    })
</script>

@endsection