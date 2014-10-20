@extends('layouts.default')

@section('header')
	<title>TweetThrough</title>
@stop

@section('customCSS')
<!-- Custom CSS -->
	    <link href="css/clean-blog.min.css" rel="stylesheet">

	    <!-- Custom Fonts -->
	    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	    <link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
	    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
@stop

@section('content')
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-custom navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">TweetThrough</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
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
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('img/home-bg-twitter-2.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1 style="text-shadow: 3px 5px 10px gray;">TweetThrough</h1>
                        <hr class="small">
                        <span class="subheading">Analyze your Tweet Data</span>
                        
                        <form action="" class="navbar-form" role="search" style="margin:auto;position:relative;top:10px;">
							<h5>Search by:</h5>
							<!--
							<div class="btn-group">
							  	<button type="button" class="btn btn-default">Text</button>
							  	<button type="button" class="btn btn-default">User</button>
							</div>-->

                            <div class="btn-group" data-toggle="buttons">
                               <label class="btn btn-default">
                                  <input type="radio" name="options" id="option1"> Text
                               </label>
                               <label class="btn btn-default">
                                  <input type="radio" name="options" id="option2"> User
                               </label>
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
							<a class="btn btn-default" href="{{URL::to('result/statistics')}}" style="background-color:#00aa00; color:white;">Submit</a>
							<!--<button onclick="location.href='/result'" type="submit" class="btn btn-default" style="background-color:#00aa00; color:white;">Submit</form>-->
							<!--</div>-->
						</form>

                    </div>
                </div>
            </div>
        </div>
    </header>
@stop

@section('footer')
    <!-- Footer -->
    <footer>
        <div class="container" style="position:relative; top:-50px;">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <ul class="list-inline text-center">
                        <li>
                            <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-github fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                    </ul>
                    <p class="copyright text-muted" style="position:relative; top:-25px;">Copyright &copy; TweetThrough 2014</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{{URL::asset('js/clean-blog.min.js')}}"></script>


@stop
