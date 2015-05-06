<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		@yield('header')

	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
	    <meta name="_token" content="{{ csrf_token() }}"/>
	    <title>CU.Tweet</title>

	    <!-- Bootstrap Core CSS -->
	    <link href="{{URL::asset('css/bootstrap.min.css')}}" rel="stylesheet">
	    <link href="{{URL::asset('css/bootstrap-switch.css')}}" rel="stylesheet">
	    <link href="{{URL::asset('css/tabdrop.css')}}" rel="stylesheet">
	    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<!-- Latest compiled and minified JavaScript -->
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

		<link href="{{URL::asset('font-awesome-4.1.0/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
		
		<style>
			.navbar-default {
	            background-color: #056ae4;
	            border-color: #7094cf;
	        }
	        .navbar-default .navbar-brand {
	            color: #eaeaea;
	        }
	        .navbar-default .navbar-brand:hover, .navbar-default .navbar-brand:focus {
	            color: #cbc7fe;
	        }
	        .navbar-default .navbar-text {
	            color: #eaeaea;
	        }
	        .navbar-default .navbar-nav > li > a {
	            color: #eaeaea;
	        }
	        .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
	            color: #cbc7fe;
	        }
	        .navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus {
	            color: #cbc7fe;
	            background-color: #7094cf;
	        }
	        .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {
	            color: #cbc7fe;
	            background-color: #7094cf;
	        }
	        .navbar-default .navbar-toggle {
	            border-color: #7094cf;
	        }
	        .navbar-default .navbar-toggle:hover, .navbar-default .navbar-toggle:focus {
	            background-color: #7094cf;
	        }
	        .navbar-default .navbar-toggle .icon-bar {
	            background-color: #eaeaea;
	        }
	        .navbar-default .navbar-collapse,
	        .navbar-default .navbar-form {
	            border-color: #eaeaea;
	        }
	        .navbar-default .navbar-link {
	            color: #eaeaea;
	        }
	        .navbar-default .navbar-link:hover {
	            color: #cbc7fe;
	        }

	        @media (max-width: 767px) {
	            .navbar-default .navbar-nav .open .dropdown-menu > li > a {
	                color: #eaeaea;
	            }
	            .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
	                color: #cbc7fe;
	            }
	            .navbar-default .navbar-nav .open .dropdown-menu > .active > a, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus {
	                color: #cbc7fe;
	                background-color: #7094cf;
	            }
	        }

	        .thaibold{
	            font-family:sans-serif,thaisansneue;
	        }

	        .onlythaibold{
	            font-family:thaisansneue;
	        }

	        .top-buffer{
	            margin-top:10px;
	        }
	        .loader { 
	        	top: 50%; 
	        	left: 50%; 
	        	margin-top: -0.55em; 
	        	margin-left: -0.55em;
	        	/*margin: 12em auto; */
	        	font-size: 10px; 
	        	position: fixed;
	        	/*position: relative; */
	        	text-indent: -9999em; 
	        	border-top: 1.1em solid rgba(0, 0, 255, 0.2); 
	        	border-right: 1.1em solid rgba(0, 0, 255, 0.2); 
	        	border-bottom: 1.1em solid rgba(0, 0, 255, 0.2); 
	        	border-left: 1.1em solid rgba(0,0,255,1); 
	        	-webkit-transform: translateZ(0); 
	        	-ms-transform: translateZ(0); 
	        	transform: translateZ(0); 
	        	-webkit-animation: load8 1.1s infinite linear; 
	        	animation: load8 1.1s infinite linear; } 
	        .loader, .loader:after { border-radius: 50%; width: 10em; height: 10em; } @-webkit-keyframes load8 { 0% { -webkit-transform: rotate(0deg); transform: rotate(0deg); } 100% { -webkit-transform: rotate(360deg); transform: rotate(360deg); } } @keyframes load8 { 0% { -webkit-transform: rotate(0deg); transform: rotate(0deg); } 100% { -webkit-transform: rotate(360deg); transform: rotate(360deg); } }
		</style>
		@yield('customCSS')

	</head>
	<body>
		<!-- check for flash notification message -->
		<!-- Navigation -->
	    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	        <div class="container">
	            <!-- Brand and toggle get grouped for better mobile display -->
	            <div class="navbar-header">
	                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	                    <span class="sr-only">Toggle navigation</span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                </button>
	                <a class="navbar-brand" href="{{URL::to('/')}}">
	                	<!-- <img src="{{URL::to('../img/CUTweet2.png')}}"></img> -->
	                	<i class="fa fa-twitter fa-fw"></i>
	                	CU.Tweet
	                </a>
	            </div>
	            <!-- Collect the nav links, forms, and other content for toggling -->
	            <div class="collapse navbar-collapse " id="bs-example-navbar-collapse-1">
	                <ul class="nav navbar-nav navbar-left">
	                    <li>
	                        <a href="{{URL::to('/')}}" class="onlythaibold" style="font-size:20px;">หน้าแรก</a>
	                    </li>
	                    <li>
	                        <a href="{{URL::to('/about')}}" class="onlythaibold" style="font-size:20px;">เกี่ยวกับเรา</a>
	                    </li>
	                    <li>
	                        <a href="{{URL::to('/databaseDetail')}}" class="onlythaibold" style="font-size:20px;">ชุดฐานข้อมูล</a>
	                    </li>
	                    <li>
	                        <a href="{{URL::to('/groupManagement')}}" class="onlythaibold" style="font-size:20px;">จัดการกลุ่มตัวอย่างผู้ใช้ทวิตเตอร์</a>
	                    </li>
	                    <li>
	                        <a href="{{URL::to('/contact')}}" class="onlythaibold" style="font-size:20px;">ติดต่อ</a>
	                    </li>
	                </ul>
	                <ul class="nav navbar-nav navbar-right">
	                	<li>
	                		<a href="{{URL::to('logout')}}" class="onlythaibold" style="font-size:20px;">ออกจากระบบ</a>
	                	</li>
	                </ul>

	            </div>
	            <!-- /.navbar-collapse -->
	        </div>
	        <!-- /.container -->
	    </nav>

		<div class="container">
        @if(Session::has('flash_notice'))
            <div class="alert alert-info">{{ Session::get('flash_notice') }}</div>
        @endif
        </div>

		@yield('content')

		@yield('footer')
		<script type="text/javascript">
			$(function() {
			    $.ajaxSetup({
			        headers: {
			            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
			        }
			    });
			    $(".loader").hide();
			});
		</script>

		
		

	</body>
</html>
