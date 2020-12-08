<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        {{ $employee->unique_id }} certificate for {{ date('Y-m-d H:i:s') }}
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

<body style="font-size: 14px;">
<div class="container">
    <div class="" id="page">
        <div class="row" id="logo">
            <div class="col" style="padding:3% 0 3% 5%; float:left">
                <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}" height="8" width="100">
            </div>
            <div class="col" style="text-align: center; font-weight: bold; padding:3% 35% 3% 0%; ">
                <p style="font-size: 18px; ">Employee Certificate</p>
            </div>
        </div>
        <div class="card-block" >
            <div class="text-center" style="font-weight: bold; ">
                <p style="font-size: 18px; text-align: center;">Certificate Tracking No:{{$employee->unique_id}}/00{{$employee->emp_certificate}}</p>
                <p style="font-size: 18px; ">{{ date('F d, Y') }}</p>
                <p style="font-size: 1.2em">TO WHOM IT MAY CONCERN</p>
            </div>
            <div class="">
                <p style="font-weight: bold; font-size: 1.2em">Employee Name: {{$employee->first_name.' '.$employee->last_name}}</p>
                <p style="font-weight: bold; font-size: 1.1em">Employee ID: {{$employee->unique_id}}</p>
            </div>
            <div class="">
                <p>
                    The Engineering and Planning Consultants Limited (EPC) certifies that the above-mentioned employee works as {{ $employee->designation->designation_name }}. {{$employee->first_name.' '.$employee->last_name}}’s in service date is {{ date('F d, Y', strtotime($employee->joining_date)) }}.
                    {{$employee->first_name}}’s gross monthly salary is {{ $salary->total_salary }}.00 BDT. {{$employee->first_name}} resides in {{$employee->current_address}} and {{$employee->first_name}}’s permanent address is {{$employee->permanent_address}}.
                    <br><br>
{{--                    This certificate is generated electronically at the request of the above-mentioned employee. To verify the authenticity of this certificate, please call our number 880-{{ $setup->phone }} between 9 a.m. and 5 p.m. (GMT+6) during EPC working days from Sunday to Thursday--}}
{{--                    and refer to the above-captioned Certificate Tracking No.--}}
                </p>
            </div>
        </div>
    </div>

    <div class="text-bottom text-right pt-5">
        <div class="row">
            <div class="offset-8">
                <hr>
                <p class=" ">HR/Admin, Manager</p>
                <p class=" ">Human Resource and Administration</p>
            </div>
            <div class="">
                <div class="" style=" margin-bottom: 50px">
                    <div class="" style="padding:3% 0 3% 5%; ">
                        <img class="img-fluid" src="{{asset('public/assets/images/epc_round.png')}}" height="20" width="150">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-bottom text-center pt-5" >
        <div class="row">
            <div class="col" style="background-color: #4a5f68; position: fixed; bottom: 0;" >
                <p class=" " style="font-size: 0.7rem;" >ERP Version 1.1 | Developed by: White Paper | Printed By: {{ Auth::user()->name }} | <span id="datetime"></span></p>
            </div>
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
    });
</script>
</body>
</html>
