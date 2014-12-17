@extends('layouts.default')
@section('customCSS')
<!-- Custom CSS -->
<link href="{{URL::asset('css/sb-admin.css')}}" rel="stylesheet">

<!-- Custom Fonts -->
<link href="{{URL::asset('font-awesome-4.1.0/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

@yield('additionalAsset')


@stop

@section('content')
<!--<header>
	<nav class="navbar navbar-default" role="navagation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example-nav-collapse">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="{{URL::to('')}}" class="navbar-brand">TweetThrough</a>
			</div>
			<div class="collapse navbar-collapse" id="example-nav-collapse">
				<ul class="nav navbar-nav">
					<li><p class="navbar-text">Search By </p></li>
					<li>
						<form action="" class="navbar-form" role="search">


							<div class="btn-group" data-toggle="buttons">
                               <label class="btn btn-default">
                                  <input type="radio" name="options" id="option1"> Text
                               </label>
                               <label class="btn btn-default">
                                  <input type="radio" name="options" id="option2"> User
                               </label>
                            </div>
									
										<div class="form-group">
											<input type="text" class="form-control" placeholder="search" name="searchText">
										</div>
										
										<a class="btn btn-default" href="result" style="background-color:#00aa00; color:white;">Submit</a>
										
									</form></li>
								</ul>
								<ul class="nav navbar-nav navbar-right">                            
									<li>
										<a href="index.php">Home</a>
									</li>
									<li>
										<a href="about.html">About</a>
									</li>
									<li>
										<a href="contact.html">Contact</a>
									</li>            
								</ul>
							</div>
						</div>
					</nav>
				</header> -->

				<!-- Page Heading -->
				<br><br>
				<div class="row">
					<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
						<h1 class="page-header thaibold">
							Search: {{$searchText}}
						</h1>
					</div>
				</div>
				<!-- /.row -->
				@yield('TabContent')

				@stop


				@section('footer')



				@stop
@stop