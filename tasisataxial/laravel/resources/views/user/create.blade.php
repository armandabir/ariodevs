

{{--session()->get("phoneNumber")--}}


@extends('layouts.master-login')
@section('form-title',"ثبت نام")
@section('content')

    <form action="{{route('user.register')}}" method="post">
        @csrf

        @method('POST')

        <div class="form-row">
            <div class="form-group col">
                <label class="font-weight-bold text-dark text-2">نام</label>
                <span class="asterisk">*</span>
                <input type="text" name="firstName" value="{{old('firstName')}}" class="form-control form-control-lg text-left form-control @error('firstName') is-invalid @enderror "  dir="ltr">
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
                <input type="text" name="lastName" value="{{old('lastName')}}" class="form-control form-control-lg text-left form-control @error('lastName') is-invalid @enderror" dir="ltr">

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
                <input type="text" name="username" value="{{old('username')}}" class="form-control form-control-lg text-left form-control @error('username') is-invalid @enderror" dir="ltr">

                @error('username')
                <span class="invalid-feedback">
                    <strong>{{$message}}</strong>
                </span>
               @enderror
            </div>

        </div>

        <div class="form-row">
            <div class="form-group col">
                <label class="font-weight-bold text-dark text-2">رمز عبور</label>
                <span class="asterisk">*</span>
                 <input type="password" name="password" value="" class="form-control form-control-lg text-left form-control @error('password') is-invalid @enderror" dir="ltr">
                 @error('password')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col">
                <label class="font-weight-bold text-dark text-2"> تکرار رمز عبور</label>
                 <input type="password" name="password_confirmation" value="" class="form-control-lg text-left form-control @error('password_confirmation') is-invalid @enderror" dir="ltr">

            </div>
        </div>

        
        <div class="form-row">
            <div class="form-group col">
                <label class="font-weight-bold text-dark text-2">ایمیل</label>
                <input type="text" name="email" value="{{old('email')}}" class="form-control form-control-lg text-left form-control @error('email') is-invalid @enderror" dir="ltr">

                    
              @error('email')
                <span class="invalid-feedback">
                    <strong>{{$message}}</strong>
                </span>
              @enderror
            </div>

       
        </div>




        <div class="form-row">
            <div class="form-group col">
                <label class="font-weight-bold text-dark text-2">آدرس</label>
                <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="" rows="5"></textarea>

                    
              @error('address')
                <span class="invalid-feedback">
                    <strong>{{$message}}</strong>
                </span>
              @enderror
            </div>

       
        </div>

        <div class="form-row">
            <div class="form-group col">
                <div>
                     <label for="gender" class="font-weight-bold text-dark text-2">جنسیت</label>
                </div>
                <div class="form-check-inline">
                    <label for="man" class="form-check-label" >مرد</label>
                    <input type="radio" name="gender" id="man" value="1" class="form-check-input @error('gender') is-invalid @enderror">
                    <label for="woman" class="form-check-label ml-4">زن</label>
                    <input type="radio" name="gender" id="woman" value="0" class="form-check-input @error('gender') is-invalid @enderror">
                    @error('gender')
                        <span class="invalid-feedback">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>

    
    
        <input type="text" name="phoneNumber" class="form-control" value="{{session()->get('phoneNumber')}}" hidden>
        
            <div class="form-group col-lg-6 mx-auto">
                <input type="submit" value="  تایید" class="btn btn-primary w-100" data-loading-text="در حال بارگذاری ...">
            </div>

         </div>
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