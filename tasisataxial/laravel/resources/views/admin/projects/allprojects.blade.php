<?php
use App\Self\Helper;

?>
@extends('layouts.master-adminDashboard')


@section('page','پروژهها من')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-light">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">عنوان</th>
                            <th scope="col">متن</th>
                            <th scope="col">عملیات</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $key=>$project)
                        <tr>
                            <th>{{++$key}}</th>
                            <td>{{$project->title}}</td>
                            <td>{{Helper::setText($project->content)->remove_tags()->remove_img()->character_limiter(500)}}</td>
                            <td>
                                <a href="{{route('project.show',$project->slug)}}" class="btn btn-warning w-100">ویرایش</a>
                                
                                @if($project->publish==0)
                                    <a href="{{route('project.publish',$project->slug)}}" class="btn btn-success w-100 mt-2">انتشار</a>
                                @else
                                    <a href="{{route('project.publish',$project->slug)}}" class="btn btn-danger w-100 mt-2">لغو انتشار</a>
                                @endif


                                <button class="btn btn-danger delete w-100 mt-2" data-id="{{$project->slug}}">حذف</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>  
    </div>
    @if(session()->has('string'))
         @include('layouts.alert')
    @endif

    <script>
        $(".delete").on("click",function(event){
            console.log
                   var dietID=$(this).attr('data-id');
                 
                            Swal.fire({
                                    icon:"error",
                                    title:'هشدار',
                                    text:"آیا از حدف پروژه مطمئن هستید ؟",
                                    showDenyButton: true,
                                    confirmButtonText: 'ادامه',
                                    denyButtonText: `برگشت`,
                                    }).then((result) => {
                                    /* Read more about isConfirmed, isDenied below */
                                    if (result.isConfirmed) {
                                        let url="{{route('project.delete',':data')}}"
                                        url=url.replace(':data',dietID);
                                        document.location.href=url;
                                    }
                                })
                   
        })      
    </script>
@endsection