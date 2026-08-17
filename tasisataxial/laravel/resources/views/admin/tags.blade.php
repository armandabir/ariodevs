@extends('layouts.master-adminDashboard')

@section('page',"تگها")

@section('content')

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <form action="{{route('tags.store')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">نام تگ</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" >
                        @error('name')
                            <strong class="invalid-feedback">
                                {{$message}}
                            </strong>
                        @enderror
                    </div>

                    <div class="form-gorup">
                        <input type="submit" name="submit" value="ثبت" class="btn btn-primary btn-block">     
                    </div>
                </form>
            </div>
            <div class="col-md-8">
                 <table class="table table-light">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">نام</th>
                            <th scope="col">مقالات</th>
                            <th scope="col">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tags as $key=>$tag)
                        <tr>
                            <th scope="row">{{++$key}}</th>
                            <td>{{$tag->name}}</td>
                            <td>
                                @foreach($tag->article as $article)
                                    <span class="bg-secondary p-1 mx-1">{{$article->title}}</span>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{route('tag.show',$tag->id)}}" class="btn btn-warning">ویرایش</a>
                                <button class="btn btn-danger delete" data-id="{{$tag->id}}">حذف</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                 </table>   
            </div>
        </div>
    </div>   
</section>


@if(session()->has('string'))
    @include('layouts.alert')
@endif
<script>
        $(".delete").on("click",function(event){
                   var tagID=$(this).attr('data-id');
                 
                            Swal.fire({
                                    icon:"error",
                                    title:'هشدار',
                                    text:"آیا از حدف تگ مطمئن هستید ؟",
                                    showDenyButton: true,
                                    confirmButtonText: 'ادامه',
                                    denyButtonText: `برگشت`,
                                    }).then((result) => {
                                    /* Read more about isConfirmed, isDenied below */
                                    if (result.isConfirmed) {
                                        let url="{{route('tag.delete',':data')}}"
                                        url=url.replace(':data',tagID);
                                        document.location.href=url;
                                    }
                                })
                   
        })      
    </script>


@endsection