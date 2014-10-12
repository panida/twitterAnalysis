@extends('layouts.default')
@section('customCSS')
<!-- Custom CSS -->
<link href="{{URL::asset('css/sb-admin.css')}}" rel="stylesheet">

<!-- Morris Charts CSS -->
<link href="{{URL::asset('css/plugins/morris.css')}}" rel="stylesheet">

<!-- Custom Fonts -->
<link href="{{URL::asset('font-awesome-4.1.0/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
@yield('additionalAsset')


@stop

@section('content')
<header>
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


							<div class="btn-group">
								<button type="button" class="btn btn-default">Text</button>
								<button type="button" class="btn btn-default">User</button>
							</div>
									<!--
									<?php echo Form::select('searchBy', array('T' => 'Text', 'U' => 'User'), 'T',['class'=>'dropdown','style'=>'color:black; font-size:16px;']);
										echo Form::text('searchText');
									 ?>
									-->

									<!--
									<ul>
										<input type="radio" name="searchType" value="Text"> Text<br>
											<input type="radio" name="searchType" value="User"> User<br>
										</ul>-->
										<div class="form-group">
											<input type="text" class="form-control" placeholder="search" name="searchText">
										</div>
										<!--<input type="checkbox" name="download-version" checked data-size="large" data-on-text="3" data-off-text="2.0.1">-->
										<!--<div style="margin-top:5px;">-->
										<a class="btn btn-default" href="result" style="background-color:#00aa00; color:white;">Submit</a>
										<!--<button onclick="location.href='/result'" type="submit" class="btn btn-default" style="background-color:#00aa00; color:white;">Submit</form>-->
										<!--</div>-->
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
				</header>

				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
						<h1 class="page-header">
							Search: <small>รัฐประหาร</small>
						</h1>
					</div>
				</div>
				<!-- /.row -->
				@yield('TabContent')

				@stop


				@section('footer')



				@stop