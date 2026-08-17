@extends("layouts.master-adminDashboard")


@section("page",'افزودن محصول')

@section("content")
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <form action="{{route('product.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="cat_id">دسته</label>
                        <select name="cat_id" id="" class="form-control">
                            @foreach($cats as $key=>$cat)
                                <option value="{{$cat['id']}}" data-parent_id="0" data-cat="{{$cat['id']}}" disabled>{{$key}}</option>
                                @if(count($cat['subcat'])>0)
                                    @foreach($cat['subcat'] as $subkey=>$subcat)
                                     <option value="{{$subcat['id']}}" data-parent_id="{{$cat['id']}}" data-cat="{{$subcat['id']}}">---{{$subkey}}</option>
                                    @endforeach
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="title">عنوان</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{old('title')}}">
                        @error('title')
                            <strong class="invalid-feedback">
                                {{$message}}
                            </strong>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="file">عکس</label>
                        <input type="file" class="form-control @error('pic') is-invalid @enderror" id="file1" name="pic[]" value="{{old('pic')}}">
                        <input type="file" class="form-control @error('pic') is-invalid @enderror" id="file2" name="pic[]" value="{{old('pic')}}">
                        <input type="file" class="form-control @error('pic') is-invalid @enderror" id="file3" name="pic[]" value="{{old('pic')}}">
                        <input type="file" class="form-control @error('pic') is-invalid @enderror" id="file4" name="pic[]" value="{{old('pic')}}">
                        @error('pic')
                            <strong class="invalid-feedback">
                                {{$message}}              
                            </strong>
                        @enderror

                    </div>
                    @if($errors->has('pic.*'))
                        <strong class="text-danger">
                            {{$errors->first('pic.*')}}
                        </strong>
                    @endif
                    <div class="form-group">
                        <label for="price">قمیت</label>
                        <input type="text" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{old('price')}}">
                        @error('price')
                            <strong class="invalid-feedback">
                                {{$message}}
                            </strong>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="editor">متن</label>
                        <textarea name="content" id="editor" class="form-control @error('content') is-invalid @enderror" cols="30" rows="10">{{old('content')}}</textarea>
                        @error('content')
                            <strong class="invalid-feedback">
                                {{$message}}
                            </strong>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tags">تگها</label>
                        <select name="tags[]" id="tags" class="form-control select-multiple" multiple="multiple">
                            @foreach($tags as $tag)
                                <option value="{{$tag->id}}">{{$tag->name}}</option>
                                
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group w-50 mx-auto mt-4">
                        <input type="submit" class="btn btn-primary btn-block" name="submit" value="ثبت">
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
        $('.select-multiple').select2();
    })
</script>


@endsection