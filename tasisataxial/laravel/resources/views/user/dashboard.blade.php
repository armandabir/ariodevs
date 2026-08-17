

{{--session()->get("phoneNumber")--}}


@extends('layouts.master-login')
@section('form-title',"ثبت نام")
@section('content')

    <form action="{{route('user.update',$id)}}" method="post">
        @csrf

        @method('POST')

        <div class="form-row">
            <div class="form-group col">
                <label class="font-weight-bold text-dark text-2">نام</label>
                <span class="asterisk">*</span>
                <input type="text" name="firstName" value="{{$firstName}}" class="form-control form-control-lg text-left form-control @error('firstName') is-invalid @enderror "  dir="ltr">
            @error('firstName')
                <span class="invalid-feedback">
                    <strong>{{$message}}</strong>
                </span>
            @enderror
            </div>

        </div>


               
        <div class="form-row">
            <div class="form-group col">
                <label class="font-weight-bold text-dark text-2">نام خانوادگی</label>
                <span class="asterisk">*</span>
                <input type="text" name="lastName" value="{{$lastName}}" class="form-control form-control-lg text-left form-control @error('lastName') is-invalid @enderror" dir="ltr">

                @error('lastName')
                <span class="invalid-feedback">
                    <strong>{{$message}}</strong>
                </span>
               @enderror
            </div>

        </div>

        <div class="form-row">
            <div class="form-group col">
                <label class="font-weight-bold text-dark text-2">نام کاربری</label>
                <span class="asterisk">*</span>
                <input type="text" name="username" value="{{$username}}" class="form-control form-control-lg text-left form-control @error('username') is-invalid @enderror" dir="ltr">

                @error('username')
                <span class="invalid-feedback">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>

        </div>


        <div class="form-row">
            <div class="form-group col">
                <label class="font-weight-bold text-dark text-2">شماره تماس</label>
                <span class="asterisk">*</span>
                <input type="text" name="phone_number" value="{{$phone_number}}" class="form-control form-control-lg text-left form-control @error('phone_number') is-invalid @enderror" dir="ltr">

                @error('phone_number')
                <span class="invalid-feedback">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>

        </div>

        

        <div class="form-row">
            <div class="form-group col">
                <label class="font-weight-bold text-dark text-2">آدرس</label>
                <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="" rows="5">{{$address}}</textarea>
                @error('address')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>
        </div>


        <div class="form-row">
            <div class="form-group col">
                <label class="font-weight-bold text-dark text-2">توضیحات سفارش</label>
                <textarea name="desc" class="form-control @error('desc') is-invalid @enderror" id="" rows="5"></textarea>
                @error('desc')
                    <span class="invalid-feedback">
                        <strong>{{$desc}}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col">
                <div>
                     <label for="price" class="font-weight-bold text-dark text-2">مبلغ فاکتور</label>
                </div>
                <div class="form-check-inline">
            
                    <label class="form-check-label text-danger" >{{number_format($price,0,",")}} تومان</label>
                </div>
            </div>
        </div>
    
        <div class="form-row">

                <div class="form-group col col-lg-4 mx-auto">
                   <a href="{{route('home')}}" class="btn btn-success w-100">صفحه اصلی</a>
                </div>

                <div class="form-group col col-lg-4 mx-auto">
                    <input type="submit" value="  تایید" class="btn btn-primary w-100" data-loading-text="در حال بارگذاری ...">
                </div>
                <div class="form-group col col-lg-4 mx-auto">
                    <a class="btn btn-danger w-100" href="{{route('logout')}}"
                      onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                      {{ __('خروج') }}
                  </a>

                </div>

        </div>
         
        </div>
    </form>
    
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
    </form>

    @if(session()->has("string"))
        @include("layouts/alert")
    @endif

    <script>
        $(document).ready(function(){
            $('.select2').select2();
        })

    </script>

@endsection