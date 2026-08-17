<!DOCTYPE html>
<html dir="rtl">
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">	

		<title>ورود</title>	

		<meta name="keywords" content="HTML5 Template">
		<meta name="description" content="Porto - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Favicon -->
		<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
		<link rel="apple-touch-icon" href="img/apple-touch-icon.png">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="{{asset('css/dashboard/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{asset('css/dashboard/fontawesome-free/css/all.min.css')}}">


		<!-- Theme CSS -->
		<link rel="stylesheet" href="{{asset('css/dashboard/theme.css')}}">
		<link rel="stylesheet" href="{{asset('css/dashboard/theme-elements.css')}}">
		<link rel="stylesheet" href="{{asset('css/dashboard/theme-blog.css')}}">
		<link rel="stylesheet" href="{{asset('css/dashboard/theme-shop.css')}}">
		
		<!-- Demo CSS -->


		<!-- Skin CSS -->
		<link rel="stylesheet" href="{{asset('css/dashboard/skins/default.css')}}"> 

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="{{asset('css/dashboard/custom.css')}}">
		<link href="{{ asset('dashboard/dist/css/select2.min.css') }}" rel="stylesheet">

		
		<script src="{{asset('jquery/jquery-3.7.1.min.js')}}"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
		
	</head>


    <body>
        <div role="main" class="main shop">
			<div class="topside">
				<div class="rectangle">
				<!-- <i class="fas fa-user-alt"></i> -->
					<img src='{{asset("assets/img/logo2.jpg")}}' alt="">
				</div>
			</div>

			<div class="space-1">
			
			</div>

			<div class="container">

				<div class="row">
					<div class="col">
						<div class="featured-boxes">
							<div class="row">
								<div class="col-md-6 mx-auto">
									<div class="featured-box featured-box-primary text-left mt-2">
										<div class="box-content">
											<h4 class="color-primary font-weight-semibold text-4 text-uppercase mb-3">@yield ('form-title')</h4>
											@yield('content')
										</div>
									</div>
								</div>
								
							</div>

						</div>
					</div>
				</div>

			</div>
           
        </div>
		<script src="{{asset('dashboard/dist/js/select2.full.min.js')}}"></script>

    </body>

    @if(session()->has("string"))
        @include("layouts/alert")

    @endif

</html>