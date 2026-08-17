@extends('layouts.master-login')


@section('content')
<form action="{{route('auth.check')}}" id="frmSignIn" method="post">
    @csrf
        <div class="form-row">
            <div class="form-group col">
                <label class="font-weight-bold text-dark text-2">نام کاربری</label>
                <input type="text" name="username" value="" class="form-control form-control-lg text-left @error('username') is-invalid @enderror" dir="ltr">
                @error('username')
                 <span class="invalid-feedback">
                    <strong>
                        {{$message}}
                    </strong>
                 </span>
                 @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col">
               
                <label class="font-weight-bold text-dark text-2">رمز عبور</label>
                <input type="password" name="password" value="" class="form-control form-control-lg text-left @error('password') is-invalid @enderror" dir="ltr">
                @error('password')
                 <span class="invalid-feedback">
                    <strong>
                        {{$message}}
                    </strong>
                 </span>
                 @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-lg-6">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="remember" value="1" class="custom-control-input" id="rememberme">
                    <label class="custom-control-label text-2" for="rememberme">به خاطر سپاری</label>
                </div>
                
            </div>
            <div class="form-group col-lg-6">

                <label class="font-weight-bold text-dark text-2">تصویر امنیتی</label>
                <p id="captcha">{!!captcha_img()!!} </p>
                <p><input type="text" class="form-control w-75" name="captcha"></p>
                <span id="reload" class="btn btn-warning">بارگذاری</span>

            </div>

            <div class="form-group col-lg-6 mx-auto mt-4">
                <input type="submit" value="ورود" class="btn btn-primary w-100" data-loading-text="در حال بارگذاری ...">
            </div>
        </div>
</form>
<div class="form-group col-lg-12">
        <div class="custom-control custom-checkbox">
            <a  href="{{route('forgetForm')}}">بازیابی رمز عبور</a>
        </div>
        <div class="custom-control custom-checkbox">
            <a  href="{{route('mobile')}}">ثبت نام نکرده اید ؟ اینجا  کلیک کنید</a>
        </div>
</div>
@if(session()->has('string'))
    @include('layouts.alert')
@endif

<script>
    $(document).ready(function(){

         $("#reload").on("click",function(){
            $('#captcha').empty()
            $('#captcha').append('{!!captcha_img()!!}')

         })

    })
</script>
@endsection