@extends('layouts.master-adminDashboard')

@section('page',$tag->name)

@section('content')
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{route('tag.update',$tag->id)}}" method="POST">
                        @csrf
                        <div class="form-gorup">
                            <label for="name">نام تگ</label>
                            <input type="text" name="name" id="name" value="{{$tag->name}}" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <span class="invalid-feedback">
                                    <strong>
                                        {{$message}}
                                    </strong>

                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="submit" name="submit" value="ویرایش" class="btn btn-warning">

                        </div>
                    </form>
                </div>

            </div>
        </div>

    </section>



@endsection