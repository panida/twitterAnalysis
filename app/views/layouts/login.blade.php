<html lang="en-US">
	<head>
		<meta charset="utf-8">

	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">

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

		</style>
	</head>
	<body>
		<div class="container">

		    <div class="row" style='margin: 30px'>
				<div class="col-md-4 col-md-offset-4">
					<div style = 'text-align:center;'>
						<i class="fa fa-twitter fa-5x" style='color:#056AE4;'></i>
						<h1 style='margin-top:10px'>CU.Tweet</h1></div>
		    	</div>
			</div>
			<div class="col-md-4 col-md-offset-4">
				@if (Session::get('error'))
			        <div class="alert alert-danger">
			        @if (is_array(Session::get('error')))
			            {{ head(Session::get('error')) }}
			        @else
			            {{{ Session::get('error') }}}
			        @endif
			        </div>
			    @endif
			    @if (Session::get('notice'))
			        <div class="alert alert-success">{{ Session::get('notice') }}</div>
			    @endif
	            <header style='border-radius:6px;background-color: rgba(200,210,250,0.5);padding:20px 30px'>
	                <h1 class="onlythaibold">เข้าสู่ระบบ</h1>
	                {{Form::open(array('url' => 'login','method'=>'post','accept-charset'=>'UTF-8'))}}
		                    <fieldset>
					    	  	<div class="form-group">
									{{ Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'ชื่อผู้ใช้', 'required' => 'required']) }}
					    		</div>
					    		<div class="form-group">
					    			{{Form::password('password', ['class' => 'form-control', 'placeholder' => 'รหัสผ่าน', 'required' => 'required'])}}
					    		</div>
					    		
					    	    {{ Form::submit('Login', array('class'=>'btn btn-lg btn-success btn-block'))}}
					    	</fieldset>
	            </header>
        	</div>
		</div>
	</body>
</html>