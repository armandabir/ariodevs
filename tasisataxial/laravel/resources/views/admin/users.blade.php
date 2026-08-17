@extends("layouts.master-adminDashboard")

@section('page','کاربران من')


@section('content')

<section class="content">

        <div class="row">
            <div class="col-md-11 mx-auto">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><span class="d-inline-block label label-success"></span></h3>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-hover table-striped" style="width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col">ردیف</th>
                                <th scope="col">نام</th>
                                <th scope="col">نام کاربری</th>
                                <th scope="col">سطح دسترسی</th>
                                <th scope="col">تلفن</th>
                                <th scope="col">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key=>$user)
                            <tr>
                                <form name="user" id="user-{{++$key}}" action="{{route('admin.user',$user->id)}}" method="POST">
                                    @csrf
                                    <td scope="row">{{$key}}</td>
                                    <td>{{$user->firstName}} {{$user->lastName}}</td>
                                    <td>{{$user->username}}</td>
                                    <td class="w-25">
                                        <div class="form-check-inline">
                                         
                                            <input type="radio" class="form-check-input ml-2" name="access" value="1" id="adminRadio" {{($user->role_as==1)?'checked':''}}>
                                            <label for="adminRadio" class="form-label ml-2">ادمین</label>
                                            <input type="radio" class="form-check-input ml-2" value="4" name="access" id="guestRadio" {{($user->role_as==4)?'checked':''}}>
                                            <label for="guestRadio" class="form-label ml-2">کاربر</label>
                                        </div>
                                    </td>
                                    <td class="text-center">{{$user->phone_number}}</td>
                                    <td>
                                        <div>   
                                            <button type="submit" class="btn btn-primary " name="action" value="role" >ثبت</button>
                                            <button type="submit" class="btn btn-danger delete" data-id="user-{{$key}}" name="action" value="delete">حذف</button>
                                            
                                        </div>
                                    </td>
                                </form>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination">
                    {{$users->links()}}
                </div>
            </div>

            </div>
        </div>

</section>

@if(session()->has('string'))
    @include('layouts.alert')
@endif

<script>
        $(".delete").on("click",function(event){
            event.preventDefault()
                   var mydata=$(this).attr('data-id');
                            Swal.fire({
                                    icon:"error",
                                    title:'هشدار',
                                    text:"آیا از حدف کاربر مطمئن هستید ؟",
                                    showDenyButton: true,
                                    confirmButtonText: 'ادامه',
                                    denyButtonText: `برگشت`,
                                    }).then((result) => {
                                    /* Read more about isConfirmed, isDenied below */
                                    if (result.isConfirmed) {
                                       document.getElementById(mydata).submit()
                                    }
                                })
                   
        })      
    </script>


@endsection