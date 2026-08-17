<!DOCTYPE html>
<html lang="fa">
    <head>
        
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">        
        <title>شیرینی قندون</title>
        
		<link rel="stylesheet" href="{{asset('css/dashboard/bootstrap.min.css')}}" media="all">
        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-print-css/css/bootstrap-print.min.css" media="print"> -->
        <link rel="stylesheet" href="{{asset('css/bootstrap-print.min.css')}}" media="print">
        <link rel="stylesheet" href="{{asset('css/print.css')}}">
        
        <script src="{{ asset('js/app.js') }}" defer></script>
        
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-8 mx-auto text-center">
                    <h4>شیرینی قندون</h4>
                    <p>سفارش وب سایت</p>
                </div>
            </div>

            <div class="row d-flex justify-content-around">
                <div class="col-4 border border-dark">
                    <div>
                        کدسفارش:
                    </div>
                    <div>
                        {{$myorder->referenceId}}
                    </div>
                </div>
                <div class="col-4 border border-dark">
                    <div>
                        شماره فاکتور:
                    </div>
                    <div class="text-center">
                        {{$myorder->id}}
                    </div>
                </div>
                <div class="col-4 border border-dark">
                <p>
                    {{verta()}}
                    </p>
                </div>

            </div>
            <br>
            <div class="row">
                <div class="col-12">
                    مشترک گرامی : آرمان دبیرمقدم
                </div>

                <div class="col-12">
                    شماره تلفن : 09361811998 
                </div>

                <div class="col-12 text-justify">
                    آدرس: رشت - چهارراه گلسار - جنب اداره کار رشت - چهارراه گلسار - جنب اداره کار
                </div>
            </div>
            <div class="row">
                <table class="table table-bordered my-4">
                    <tr>
                        <th>نام کالا</th>
                        <th>فی</th>
                        <th>مقدار</th>
                        <th>قیمت</th>
                    </tr>
                    @foreach($products as $key=>$product)
                        <tr>
                            <td>{{$product->name}}</td>
                            <td>{{number_format($product->price,0,",")}}</td>
                            <td>{{$orders[$key]->qty>0.75?number_format($orders[$key]->qty,2,","):$orders[$key]->qty*1000}}{{$orders[$key]->qty>0.75?"کیلوگرم":" گرم"}}</td>
                            <td>{{number_format($orders[$key]->price,0,",")}}</td>
                        </tr>
                     @endforeach

                </table>
            </div>
            <div class="row">
                <div class="col-12">
                    <p>جمع کل: {{number_format($myorder->price,0,",")}} تومان </p>
            </div>
        </div>
           
        </div>
    
        <script>
            console.log("test")
            window.print();  
            document.close()
            </script>
    </body>
</html>