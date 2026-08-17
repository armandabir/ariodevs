@extends ("layouts.master-login")
@section('form-title','کد تایید را وارد کنید')
@section ("content")

{{$rndNumber}}
<form method="post" action="{{route('confirmForget',$rndNumber)}}">
    @csrf

    <div class="form-row col">
   
        <div class="form-group col">
            <label class="font-weight-bold text-dark text-2">کد تایید</label>
            <input type="text" name="confirmcode" class="form-control form-control-lg text-left @error('confirmcode') is-invalid @enderror" dir="ltr">
            @error('confirmcode')
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

        </div>
        <div class="form-group col-lg-6">
            <input type="submit" value="تایید" class="btn btn-primary float-right" data-loading-text="در حال بارگذاری ...">
        </div>

    </div>
</form>

@endsection