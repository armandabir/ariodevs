<?php
use App\Self\Helper;

?>
@extends('layouts.master-adminDashboard')


@section('page','محصولات من')

@section('content')

    <style>
        .img-container{
            width: 200px;
            height: 200px;

        }

        .img-container img{
            width: 100%;
            height:100%;
            object-fit:contain;
        }

    </style>
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
                        @foreach($products as $key=>$product)
                           @php
                             $pic=json_decode($product->pic)[0]
                           @endphp
                        <tr>
                            <th>{{++$key}}</th>
                            <td>{{$product->name}}</td>
                            <td>
                                <div class="img-container">
                                    <img src='{{asset("storage/products/$pic")}}' alt="">
                                </div>
                            </td>
                            <td>{{Helper::setText($product->content)->remove_tags()->remove_img()->character_limiter(500)}}</td>
                            <td>
                                <a href="{{route('product.show',$product->slug)}}" class="btn btn-warning w-100">ویرایش</a>
                                
                                @if($product->publish==0)
                                    <a href="{{route('product.publish',$product->slug)}}" class="btn btn-success w-100 mt-2">انتشار</a>
                                @else
                                    <a href="{{route('product.publish',$product->slug)}}" class="btn btn-danger w-100 mt-2">لغو انتشار</a>
                                @endif


                                <button class="btn btn-danger delete w-100 mt-2" data-id="{{$product->slug}}">حذف</button>
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
                                    text:"آیا از حدف محصول مطمئن هستید ؟",
                                    showDenyButton: true,
                                    confirmButtonText: 'ادامه',
                                    denyButtonText: `برگشت`,
                                    }).then((result) => {
                                    /* Read more about isConfirmed, isDenied below */
                                    if (result.isConfirmed) {
                                        let url="{{route('product.delete',':data')}}"
                                        url=url.replace(':data',dietID);
                                        document.location.href=url;
                                    }
                                })
                   
        })      
    </script>
@endsection