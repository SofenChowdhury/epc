<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        Projects List
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
            <p style="margin-top: 25px; font-size: 26px; ">Projects List</p>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-8"></div>
    </div>
    <div class="card-block">
        <div class="table-responsive">
            <table id="basic-btn" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Sl.</th>
                    <th>Project ID</th>
                    <th>Project Name</th>
                    <th>Project Phase</th>
                    <th>Funded By</th>
                    <th>Contract Type</th>
                    <th>JV Associates</th>
                    <th>Client</th>
                    <th>Status</th>
                    <th>Ministry</th>
                    <th>PD Contact</th>
                </tr>
                </thead>
                <tbody>
                @php $i = 1 @endphp
                @foreach($projects as $project)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $project->project_code }}-00{{ $project->project_phase }}</td>
                        <td>{{$project->project_name}}</td>
                        <td>
                            @if($project->project_phase == 1) EOI
                            @elseif($project->project_phase == 2) Proposal
                            @elseif($project->project_phase == 3) DD
                            @elseif($project->project_phase == 4) Supervision
                            @elseif($project->project_phase == 5) PM
                            @endif
                        </td>
                        <td>
                            @if( isset($project->funded_by))
                                {{ $project->funded->client_name }}
                            @endif
                        </td>
                        <td>
                            @if( $project->contract_type == 1)
                                JV
                            @elseif( $project->contract_type == 2)
                                Subconsultant
                            @else
                                Lead
                            @endif
                        </td>
                        <td>{{ $project->association }}</td>
                        <td>
                            @if( isset($project->client_id))
                                {{ $project->clients->client_name }}
                            @endif
                        </td>
                        <td style="color: blue;">{{ ucwords($project->project_status) }}</td>
                        <td>
                            @if( isset($project->client_id))
                                {{ $project->clients->ministry }}
                            @endif
                        </td>
                        <td>
                            Name: {{ $project->contact_person }} <br>
                            Designation{{ $project->designation }} <br>
                            Address: {{ $project->contact_person_address }} <br>
                            Phone:  {{ $project->contact_person_phone }}<br>
                            Email: {{ $project->contact_person_email }}<br>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="text-bottom text-center pt-5 mt-5" >
    <div class="row">
        <div class="col" style="background-color: #4a5f68; position:fixed; bottom: 0" >
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
        window.setTimeout('history.back()',1000);
        // window.close();
        // history.back();
        // history.go(-1);
    });
</script>
</body>
</html>
