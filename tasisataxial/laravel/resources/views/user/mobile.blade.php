@extends ('layouts.master-login')
@section('form-title','ثبت نام و ورود')
@section ('content')

<form  method="get" action="{{route('smsCode')}}">
    @csrf  
    <div class="form-row">
        <div class="form-group col">
            <label class="font-weight-bold text-dark text-2">شماره موبایل</label>
            <input type="text" value="" name="phone_number" class="form-control form-control-lg text-left @error('phone_number') is-invalid @enderror" dir="ltr">
            @error('phone_number')
            <span class="invalid-feedback">
                <strong>{{$message}}</strong>
            </span>
            @enderror
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group col-lg-6">

        </div>
        <div class="form-group col-lg-6">
            <input type="submit" value=" ارسال کد تایید" class="btn btn-primary float-right" data-loading-text="در حال بارگذاری ...">
        </div>

    </div>
</form>

@if($errors->any())
    {{$errors->first()}}
@endif
    

@endsection