<script>
    document.addEventListener('DOMContentLoaded',function(){
        Swal.fire({
            title:"{{session()->get('title')}}",
            text:"{{session()->get('string')}}",
            icon:"{{session()->get('icon')}}",
            confirmButtonText: 'باشه'
        })
    })
</script>