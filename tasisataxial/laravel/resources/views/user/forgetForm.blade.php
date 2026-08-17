@extends ('layouts.master-login')

@section('content')

<form action="{{route('forgetCode')}}">
    @csrf  
    <div class="form-row">
        <div class="form-group col">
            <label class="font-weight-bold text-dark text-2">شماره همراه</label>
            <input type="text" value="" name="phone_number" class="form-control form-control-lg text-left @error('phoneNumber') is-invalid @enderror" dir="ltr">
            @error('phoneNumber')
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
            <input type="submit" value="تایید" class="btn btn-primary float-right" data-loading-text="در حال بارگذاری ...">
        </div>

    </div>
</form>

@if($errors->any())
    {{$errors->first()}}
@endif



@endsection