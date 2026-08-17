
@extends('layouts.master-login')
@section('form-title',"بازیابی رمز عبور")
@section('content')

    <form  method="POST" action="{{route('resetPassword',$user_id)}}" >
        @csrf
        <div class="form-row">
            <div class="form-group col">
                <label class="font-weight-bold text-dark text-2">نام کاربری : </label>
                <span class="asterisk">{{$username}}</span>
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

    
        
            <div class="form-group col-lg-6 mx-auto">
                <input type="submit" value="  تایید" class="btn btn-primary w-100" data-loading-text="در حال بارگذاری ...">
            </div>

         </div>
    </form>

    @if(session()->has("string"))
        @include("layouts/alert")

    @endif

@endsection