
@extends('layouts.master-adminDashboard')
@section('page','سفارشات')


@section('content')

<section class="content">
    <div class="container">
        <form action="{{route('order.search')}}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="search" class="form-label">شماره پیگیری</label>
                    <input type="text" name="search" class=" form-control @error('search') is-invalid @enderror">
                    
                    @error('search')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <div class="d-grid gap-2 d-md-block">
                        <label for="" class="form-label"> </label>
                        <button type="submit" class="form-control btn-primary my-auto" >جستجو</button>
                    </div>
                </div>
            </div>
        </form>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">سفارشات <span class="d-inline-block label label-success"></span></h3>
                        
                        {{--<div class="box-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control pull-right" placeholder="جستجو">
                                
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>--}}
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>شماره</th>
                                <th>نام و نام خانوادگی</th>
                                <th>شماره سفارش</th>
                                <th>تاریخ</th>
                                <th>قیمت</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                            
                            @if(isset($orders))
                            
                            
                                @foreach($orders as $key=>$order)
                           
            
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$order->firstName." ".$order->lastName}}</td>
                                    <td>{{$order->referenceId}}</td>
                                    <td>{{verta($order->created_at)}}</td>
                                    <td>{{$order->price}}</td>
                                    <td class="{{$order->done===1?'text-success':'text-danger'}}">{{$order->done==1?'انجام شده':'انجام نشده'}}</td>
                                    <td>
                                    <a href="{{route('order.details',$order->id)}}" class="btn btn-primary">جزئیات</a>
                                    </td> 
                                </tr>
                                @endforeach
                            </table>
                            
                            <div class="pagination mx-auto w-50">
                                {{$orders->links()}}
                            </div>

                            @endif
                    </div>
            <!-- /.box-body -->
                </div>
          <!-- /.box -->
        </div>
        </div>
    </div>

</section>
@if(session()->has('string'))
    @include('layouts.alert')
@endif
@endsection