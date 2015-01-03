@extends('layouts.default')
@section('customCSS')
    <!-- Custom CSS -->
    <link href="{{URL::asset('css/sb-admin.css')}}" rel="stylesheet">
    <style type="text/css">
    .badge{
        font-size: 15px;
    }
    </style>
    <style>
        .chat {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .chat li {
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px dotted #999;
        }

        .chat li.left .chat-body {
            margin-left: 60px;
        }

        .chat li.right .chat-body {
            margin-right: 60px;
        }

        .chat li .chat-body p {
            margin: 0;
        }

        .panel .slidedown .glyphicon,
        .chat .glyphicon {
            margin-right: 5px;
        }

        .chat-panel .panel-body {
            height: 350px;
            overflow-y: scroll;
        }
    </style>
    {{ HTML::style('css/jquery-ui.css'); }}
    {{ HTML::script('js/jquery-ui-1.10.4.min.js'); }}
    <script>
        $(function() {
            $( document ).tooltip({
                position:{
                    my: "center bottom-20",
                    at: "center top",
                },
                container: 'body'
            });
        });
    </script>

@stop

@section('content')
    <br><br>

    <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
        <h1 class="page-header onlythaibold">
            จัดการกลุ่มตัวอย่างวิจัย
        </h1>

        <div class="row">
            <div class="col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title onlythaibold" style="font-size:20px;"><i class="fa fa-group fa-fw"></i> กลุ่มตัวอย่างวิจัยทั้งหมด</h2>
                    </div>
                    <div class="panel-body onlythaibold" style="font-size:18px;">
                        <div class="list-group">
                            <a href="{{URL::to('/groupManagement')}}" class="list-group-item">
                                <!-- <span class="badge">0</span> -->
                                <i class="fa fa-fw fa-plus-circle" style="color:green;"></i> เพิ่มกลุ่มตัวอย่างใหม่
                            </a>
                            @foreach($groups as $group)
                                <a href="{{URL::to('/group/'.$group->groupid)}}" class="list-group-item">
                                    <span class="badge">{{$memberCount[$group->groupid]}}</span>
                                    <i class="fa fa-fw fa-folder-open" style="color:#EBE241;"></i> {{$group->groupname}}
                                </a>
                            @endforeach                       
                        </div>                        
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                @yield('addEditGroup')                
            </div>
        </div>



@stop

@section('footer')
        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; CU.Tweet 2014</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->
@stop