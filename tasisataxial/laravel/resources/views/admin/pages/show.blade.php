<?php
use App\Self\Helper;

?>

@extends ("layouts.master-adminDashboard")

@section('title',$items[0]->sect_name)

@section('page',$items[0]->sect_name)
@section('content')

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-light">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">عنوان</th>
                            <th scope="col">عکس</th>
                            <th scope="col">متن</th>
                            <th scope="col">عملیات</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $key=>$item)
                        <tr>
                            <th>{{++$key}}</th>
                            <td>{{$item->title}}</td>
                            <td>
                                @if($item->pic!=null)
                                    @if(is_array(json_decode($item->pic,true)))
                                        $pic=json_decode($item->pic,true)
                                        <div class="img-container">
                                            <img src='{{storage("pages/$pic[0]")}}' alt="">
                                        </div>          
                                    @else
                                        <div class="img-container">
                                            <img src='{{asset("storage/pages/$item->pic")}}' alt="">
                                        </div>  
                                    @endif
                                @endif
                            </td>
                            <td>{{Helper::setText($item->desc)->remove_tags()->remove_img()->character_limiter(500)}}</td>
                            <td>
                                <a href="{{route('page.item.edit',$item)}}" class="btn btn-warning w-100">ویرایش</a>
                                <button class="btn btn-danger delete w-100 mt-2" data-id="{{$item->id}}">حذف</button>
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

    @include('layouts/alert')
@endif

    <script>
        $(".delete").on("click",function(event){
                   var itemID=$(this).attr('data-id');
                 
                            Swal.fire({
                                    icon:"error",
                                    title:'هشدار',
                                    text:"آیا از حدف آیتم مطمئن هستید ؟",
                                    showDenyButton: true,
                                    confirmButtonText: 'ادامه',
                                    denyButtonText: `برگشت`,
                                    }).then((result) => {
                                    /* Read more about isConfirmed, isDenied below */
                                    if (result.isConfirmed) {
                                        let url="{{route('page.item.delete',':data')}}"
                                        url=url.replace(':data',itemID);
                                        document.location.href=url;
                                    }
                                })
                   
        })      
    </script>

@endsection