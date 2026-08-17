
@extends('layouts.master-adminDashboard')
@section('page','سفارش'.$myorder->referenceId)
@section('content')
    <section class="content">
        
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-widget">
                        <div class="card-header">
                            <div class="user-block">
                            <h5>مشخصات کاربر</h5>
                            </div>
                            <!-- /.user-block -->
                            <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Mark as read">
                                <i class="fa fa-circle-o"></i></button>
                            <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i>
                            </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- post text -->
                            <div class="row">
                                <div class="col-md-4 col-6">
                                    <label class="form-label">نام و نام خانوادگی :</label>
                                    <p><span>{{$myorder->firstName}}</span> <span>{{$myorder->lastName}}</span></p>

                                    <label class="form-label">شماره سفارش:</label>
                                    <p>{{$myorder->referenceId}}</p>
                                </div>
                                <div class="col-md-4 col-6">
                                <label class="form-label">جنسیت:</label>
                                <p>{{$myorder->gender==1?"مرد":"زن"}}</p>

                                <label class="form-label">تاریخ سفارش:</label>
                                <p>{{verta($myorder->created_at)}}</p>
                                </div>
                                <div class="col-md-4 col-6">
                                <label class="form-label">شماره همراه:</label>
                                <p>{{$myorder->phone_number}}</p>

                                <label class="form-label">ایمیل:</label>
                                <p>{{$myorder->email}}</p>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">آدرس:</label>
                                    <p>{{$myorder->address}}</p>
                                </div>
                            
                            </div>
                            
                        </div>
        

                    
                    </div>  
                </div>


                <div class="col-md-12">
                    <div class="card card-widget">
                        <div class="card-header">
                            <div class="user-block">
                            <h5>جزئیات سفارش</h5>
                            </div>
                            <!-- /.user-block -->
                            <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Mark as read">
                                <i class="fa fa-circle-o"></i></button>
                            <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i>
                            </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- post text -->
                            <div class="row">
                                <div class="col-md-4">
                                        
                                        @foreach($products as $key=>$porduct)
                                            <div>
                                                <label class="form-label">{{$key+1}}-{{$porduct->name}} </label>

                                                <p>{{$orders[$key]->qty}} کیلوگرم</p>
                                            </div>
                                            <hr>
                                        @endforeach
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">توضیحات </label>
                                     <p>
                                        {{$myorder->description}}
                                     </p>   
                                </div>
                                

                                <div class="col-md-4">
                                    <label class="form-label">مبلغ فاکتور </label>
                                     <p>
                                        {{$myorder->price}}
                                     </p>   
                                </div>
                                
                            
                            </div>
                            
                        </div>
        

                    
                    </div>  
                </div>


                <div class="col-md-12">
                    <div class="card card-widget">
                        <div class="card-header">
                            <div class="user-block">
                            <h5>عملیمات</h5>
                            </div>
                            <!-- /.user-block -->
                            <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Mark as read">
                                <i class="fa fa-circle-o"></i></button>
                            <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i>
                            </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body col-md-7 mx-auto">
                            <!-- post text -->
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="{{route('home')}}" class="btn btn-success w-100">صفحه اصلی</a>
                                </div>

                                <div class="col-md-4">
                                     <a href="" class="btn btn-danger w-100">انجام شد</a>
                                </div>

                                
                                <div class="col-md-4">
                                     <a href="#" class="btn btn-primary w-100" id="print">پرینت</a>
                                </div>

                            
                            </div>
                            
                        </div>
        

                    
                    </div>  
                </div>
            </div>

            
        </div>


</section>

<script>
    const button = document.getElementById('print')
    let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,
width=402px,height=500,left=100,top=100`
    button.onclick = () => {
        window.open("{{route('orderPrint')}}",'فاکتور',params);
    };
</script>

@endsection