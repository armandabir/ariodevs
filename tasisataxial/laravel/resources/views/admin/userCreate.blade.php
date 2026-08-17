@extends('layouts.master-adminDashboard')


@section('page','ایجاد کاربر')


@section('content')

 <div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto" >
                   
                <form action="{{route('admin.register')}}" method="post">
                        @csrf

                        @method('POST')

                        <div class="form-row">
                            <div class="form-group col">
                                <label class="font-weight-bold text-dark text-2">نام</label>
                                <span class="asterisk">*</span>
                                <input type="text" name="firstName" value="{{old('firstName')}}" class=" form-control form-control-lg text-right form-control @error('firstName') is-invalid @enderror "  dir="ltr">
                                
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
                                <input type="text" name="lastName" value="{{old('lastName')}}" class="  form-control form-control-lg text-right  form-control @error('lastName') is-invalid @enderror" dir="ltr">

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
                                <input type="text" name="username" value="{{old('username')}}" class="  form-control form-control-lg text-right  form-control @error('username') is-invalid @enderror" dir="ltr">

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
                                <input type="password" name="password" value="" class="form-control  form-control-lg text-right  form-control @error('password') is-invalid @enderror" dir="ltr">
                                @error('password')
                                    <span class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col">
                                <label class="font-weight-bold text-dark text-2"> تکرار رمز عبور</label>
                                <input type="password" name="password_confirmation" value="" class="form-control-lg text-right  form-control @error('password_confirmation') is-invalid @enderror" dir="ltr">

                            </div>
                        </div>

                       {{-- <div class="from-row">
                            <div class="form-group col-md-12 mx-auto" >
                                <label for="event_place">بخش</label>
                                <span class="asterisk">*</span>
                                <select class="select2 form-control @error('event_place') is-invalid  @enderror" id="event_place" name="event_place">
                                        <option value="" selected>یک بخش را انتخاب کنید</option>
                                    @foreach($event_places as $place)
                                        <option value="{{$place->id}}">{{$place->name}}</option>
                                    @endforeach
                                    
                                </select>

                                @error('event_place')
                                    <span class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>--}}
                                        
                        
                        <div class="form-row">
                            <div class="form-group col">
                                <label class="font-weight-bold text-dark text-2">ایمیل</label>
                                <input type="text" name="email" value="{{old('email')}}" class="form-control  form-control-lg text-right  form-control @error('email') is-invalid @enderror" dir="ltr">

                                    
                            @error('email')
                                <span class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                            </div>

                    
                        </div>

                        <div class="form-row">
                            <div class="form-group col is-invalid">
                                <div>
                                    <label for="gender" class="font-weight-bold text-dark text-2">جنسیت</label>
                                </div>
                                <div class="form-check-inline">
                                    <label for="man" class="form-check-label" >مرد</label>
                                    <input type="radio" name="gender" id="man" value="1" class="form-check-input @error('gender') is-invalid @enderror ml-4">
                                    <label for="woman" class="form-check-label ">زن</label>
                                    <input type="radio" name="gender" id="woman" value="0" class="form-check-input @error('gender') is-invalid @enderror">
                                    @error('gender')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    
                       <div class="form-row">
                             <div class="form-group col">
                                 <label class="font-weight-bold text-dark text-2">شماره تلفن</label>
                                  <span class="asterisk">*</span>
                                 <input type="text" name="phoneNumber" class="form-control text-right @error('phoneNumber') is-invalid @enderror " value="{{old('phoneNumber')}}" >
                            @error('phoneNumber')
                                <span class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror       
                            
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


            </div>
        </div>

    </div>

 </div>

 <script>
        $(document).ready(function(){
            $('.select2').select2();
        })

</script>
@endsection