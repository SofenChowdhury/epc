<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        @if( isset($project->project_name))
            {{ $project->project_name}}
        @endif
        {{ date('Y-m-d H:i:s') }}
    </title>

    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('public/bower_components/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/pages/waves/css/waves.min.css')}}" type="text/css" media="all">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/icon/themify-icons/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/pages/chart/radial/css/radial.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{asset('public/assets/pages/list-scroll/list.css')}}" type="text/css" media="all">
</head>

<body>
<div class="card-block" id="page">

    <div class="row" id="logo">
        <div class="col-md-4" style="padding:3% 0 3% 5%;">
            <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}" height="10" width="120">
        </div>
        <div class="col-md-4" style="text-align: center; font-weight: bold; padding:3% 0 3% 5%;">
            <p style="margin-top: 25px; font-size: 26px; ">Project Details of {{ $project->project_name }}</p>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-8"></div>
    </div>
    <div class="card-block">
        <div class="table-responsive">
            <table id="" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Sl No.</th>
                    <th>Project Phase</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Remarks</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($tasks))
                    @php $i = 1 @endphp
                    @foreach($tasks as $task)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td> 00{{ $task->project_phase }}</td>
                            <td>{{ $task->task_name }}</td>
                            <td style="color: blue;">{{ ucwords($task->task_status) }}</td>
                            <td>{{ date('d-M-Y', strtotime($task->due_date)) }}</td>
                            <td>{{ $task->description }}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="text-bottom text-center pt-5 mt-5" >
    <div class="row">
        <div class="col" style="background-color: #4a5f68" >
            <p class=" " style="font-size: 0.9rem; background-color: #4a5f68" >ERP Version 1.1 | Developed by: White Paper | Printed By: {{ Auth::user()->name }} | <span id="datetime"></span></p>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{asset('public/bower_components/jquery/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/bower_components/jquery-ui/js/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/bower_components/popper.js/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/bower_components/bootstrap/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/assets/pages/widget/excanvas.js')}}"></script>
<script type="text/javascript" src="{{asset('public/bower_components/jquery-slimscroll/js/jquery.slimscroll.js')}}"></script>
<script type="text/javascript" src="{{asset('public/bower_components/modernizr/js/modernizr.js')}}"></script>
<script type="text/javascript" src="{{asset('public/bower_components/chart.js/js/Chart.js')}}"></script>
<script type="text/javascript" src="{{asset('public/assets/js/SmoothScroll.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function(){
        var dt = new Date();
        document.getElementById("datetime").innerHTML = dt.toLocaleString();

        window.focus();
        window.print();
        window.setTimeout('window.close()',1000);
        // window.close();
        // history.back();
        // history.go(-1);
    });
</script>
</body>
</html>
