@extends('layouts.master-adminDashboard')


@section('page','افزودن مقاله')


@section('content')
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <form action="{{route('article.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="cats_id">دسته</label>
                        <select name="cats_id" id="cats_id" class="form-control">
                            @foreach($cats as $cat)
                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="title">عنوان</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{old('title')}}">
                        @error('title')
                            <strong class="invalid-feedback">
                                {{$message}}
                            </strong>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="file">عکس</label>
                        <input type="file" class="form-control @error('pic') is-invalid @enderror" id="file" name="pic" value="{{old('pic')}}">
                        @error('pic')
                            <strong class="invalid-feedback">
                                {{$message}}              
                            </strong>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="editor">متن</label>
                        <textarea name="content" id="editor" class="form-control cke_rtl @error('content') is-invalid @enderror" cols="30" rows="10">{{old('content')}}</textarea>
                        @error('content')
                            <strong class="invalid-feedback">
                                {{$message}}
                            </strong>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tags">تگها</label>
                        <select name="tags[]" id="tags" class="form-control select-multiple" multiple="multiple">
                            @foreach($tags as $tag)
                                <option value="{{$tag->id}}">{{$tag->name}}</option>
                                
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group w-50 mx-auto mt-4">
                        <input type="submit" class="btn btn-primary btn-block" name="submit" value="ثبت">
                    </div>

                </form>
            </div>
        </div>

    </div>
</section>

<script src="{{asset('js/ckeditor/build/ckeditor.js')}}"></script>

<script>

    $(document).ready(function(){
        $('.select-multiple').select2();
    })
    function MyCustomUploadAdapterPlugin( editor ) {
    editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
        // Configure the URL to the upload script in your back-end here!
        return new MyUploadAdapter( loader );
    };
}

// ...

ClassicEditor
    .create( document.querySelector( '#editor' ), {
        extraPlugins: [ MyCustomUploadAdapterPlugin ],
        language: 'fa'
        // ...
    } )
    .catch( error => {
        console.log( error );
    } );


    class MyUploadAdapter {
    constructor( loader ) {
        // The file loader instance to use during the upload.
        this.loader = loader;
    }

    // Starts the upload process.
    upload() {
        return this.loader.file
            .then( file => new Promise( ( resolve, reject ) => {
                this._initRequest();
                this._initListeners( resolve, reject, file );
                this._sendRequest( file );
            } ) );
    }

    // Aborts the upload process.
    abort() {
        console.log(this.xhr);
        if ( this.xhr ) {
            this.xhr.abort();
        }
    }

    // Initializes the XMLHttpRequest object using the URL passed to the constructor.
    _initRequest() {
        const xhr = this.xhr = new XMLHttpRequest();

        // Note that your request may look different. It is up to you and your editor
        // integration to choose the right communication channel. This example uses
        // a POST request with JSON as a data structure but your configuration
        // could be different.
        xhr.open( 'POST', "{{route('article.imageUploder',['_token'=>csrf_token()])}}", true );
        xhr.responseType = 'json';
    }

    // Initializes XMLHttpRequest listeners.
    _initListeners( resolve, reject, file ) {
        const xhr = this.xhr;
        const loader = this.loader;
        const genericErrorText = `Couldn't upload file: ${ file.name }.`;

        xhr.addEventListener( 'error', () => reject( genericErrorText ) );
        xhr.addEventListener( 'abort', () => reject() );
        xhr.addEventListener( 'load', () => {
            const response = xhr.response;

            // This example assumes the XHR server's "response" object will come with
            // an "error" which has its own "message" that can be passed to reject()
            // in the upload promise.
            //
            // Your integration may handle upload errors in a different way so make sure
            // it is done properly. The reject() function must be called when the upload fails.
            if ( !response || response.error ) {
                return reject( response && response.error ? response.error.message : genericErrorText );
            }

            // If the upload is successful, resolve the upload promise with an object containing
            // at least the "default" URL, pointing to the image on the server.
            // This URL will be used to display the image in the content. Learn more in the
            // UploadAdapter#upload documentation.
            resolve(response );
        } );

        // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
        // properties which are used e.g. to display the upload progress bar in the editor
        // user interface.
        if ( xhr.upload ) {
            xhr.upload.addEventListener( 'progress', evt => {
                if ( evt.lengthComputable ) {
                    loader.uploadTotal = evt.total;
                    loader.uploaded = evt.loaded;
                }
            } );
        }
    }

    // Prepares the data and sends the request.
    _sendRequest( file ) {
        // Prepare the form data.
        const data = new FormData();

        data.append( 'upload', file );

        // Important note: This is the right place to implement security mechanisms
        // like authentication and CSRF protection. For instance, you can use
        // XMLHttpRequest.setRequestHeader() to set the request headers containing
        // the CSRF token generated earlier by your application.

        // Send the request.
        this.xhr.send( data );
    }
}

</script>
@if(session()->has('string'))
    @include('layouts.alert')
@endif

@endsection

