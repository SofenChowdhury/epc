<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        {{ $employee->unique_id }} Salary
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
<div class="card-block" id="page">
    <div class="row" id="logo">
        <div class="" style="padding:3% 0 0 5%; float:left">
            <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}" height="10" width="120">
        </div>
    </div>

    <div class="card-block" >
        <div class=" text-center">
            <p style="font-weight: bold; font-size: 18px; ">Salary statement for the month of <br> {{ isset($month) ? $month :  $start_month . ' to ' . $end_month }}</p>
            <p style="font-weight: bold; font-size: 1.3em">Employee Name: {{$employee->first_name.' '.$employee->last_name}}</p>
            <p style="font-weight: bold; font-size: 1.2em">Designation: {{ isset($employee->designation) ? $employee->designation->designation_name : ''}}</p>
            <p style="font-weight: bold; text-align: left">ID No: {{$employee->unique_id}}</p>
            <p style="font-weight: bold; text-align: left">TIN Number: {{$employee->tin}}</p>
            <p style="font-weight: bold; text-align: left">Bank Name: {{ isset($employee->bank) ? $employee->bank->bank_name : ''}}</p>
        </div>
        <div class="">
            <table id="" class="table table-striped table-bordered" border="1">
                <tbody>
                <tr style="text-align: center">
                    <th colspan="2">Earnings</th>
                    <th colspan="2">Deduction</th>
                </tr>
                <tr>
                    <th>Gross Salary</th>
                    <td>
                        @if( isset($result->present_salary) )
                            {{ $result->present_salary }}
                        @else

                        @endif
                    </td>
                    <th>Provident Fund</th>
                    <td>
                        @if( isset($result->provident_fund) )
                            {{ $result->provident_fund }}
                        @else
                            0
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Bonus</th>
                    <td>
                        @if( isset($result->bonus) )
                            {{ $result->bonus }}
                        @endif
                    </td>
                    <th>Salary Advance</th>
                    <td>
                        @if( isset($result->advance) )
                            {{ $result->advance }}
                        @else
                            0
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Overtime Total</th>
                    <td>
                        @if( isset($result->overtime) )
                            {{ $result->overtime }}
                        @endif
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th>Total Addition</th>
                    <td>
                        @if( isset($result->gross) )
                            {{ $result->gross }}
                        @endif
                    </td>
                    <th>Total Deduction</th>
                    <td>
                        @if( isset($result->total_deduction) )
                            {{ $result->total_deduction }}
                        @else
                            0
                        @endif
                    </td>
                </tr>
                <tr>
                    <th colspan="3">Net Salary (Before tax)</th>
                    <th>
                        @if( isset($result->gross) )
                            {{ $result->gross }}
                        @else
                            0
                        @endif
                    </th>
                </tr>
                <tr>
                    <th colspan="3">Total Deductions</th>
                    <th>
                        @if( isset($result->total_deduction) )
                            {{ $result->total_deduction }}
                        @else
                            0
                        @endif
                    </th>
                </tr>
                <tr>
                    <th colspan="3">Tax Deducted at Source</th>
                    <th>
                        @if( isset($result->tax_payable) )
                            {{ $result->tax_payable }}
                        @else
                            0
                        @endif
                    </th>
                </tr>
                <tr>
                    <th colspan="3">Conveyance Addition </th>
                    <th>
                        @if( isset($result->conveyance) )
                            {{ $result->conveyance }}
                        @else
                            0
                        @endif
                    </th>
                </tr>
                <tr style="color: blue">
                    <th colspan="3">Net Salary (After tax)</th>
                    <th>
                        @if( isset($result->net_salary) )
                            {{ $result->net_salary }}
                        @else
                            0
                        @endif
                    </th>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="">
            @if(isset($chalans))
                @foreach($chalans as $chalan)
                    <p style="font-weight: bold;">Chalan Number: {{$chalan->chalan_no}}</p>
                @endforeach
            @endif
        </div>
        <div class="">
            <br>
{{--            <p>This certificate is generated electronically at the request of the above-mentioned employee. To verify the authenticity of this certificate, please call our number 880-{{ $setup->phone }} between 9 a.m. and 5 p.m. (GMT+6) during EPC working days from Sunday to Thursday and refer to the above-captioned ID No.</p>--}}
        </div>
    </div>
</div>

<div class="text-bottom text-left pt-5">
    <div class="row">
        @if(isset($authorizes))
            @foreach($authorizes as $authorize)
                @if($authorize->serial_no <= 3)
                    <div class="col">
                        <hr>
                        <p class=" ">{{ $authorize->user->name }}</p>
                        <p class=" ">{{ $authorize->user->employee->designation->designation_name }}</p>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>

<div class="text-bottom text-center pt-5" >

    <div class="row">
        <div class="" style=" margin-bottom: 50px; margin-left: 50px;">
            <div class="" style="padding:3% 0 3% 15%; display: table-header-group /*position: fixed; top: 0;*/">
                <img class="img-fluid" src="{{asset('public/assets/images/epc_round.png')}}" height="20" width="150">
            </div>
        </div>
        <div class="col" style="background-color: #4a5f68; position: fixed; bottom: 0;" >
            <p class=" " style="font-size: 0.7rem;" >ERP Version 1.1 | Developed by: White Paper | Printed By: {{ Auth::user()->name }} | <span id="datetime"></span></p>
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

        window.open();
        window.focus();
        window.print();
        window.setTimeout('history.back()',1000);
    });
</script>
</body>
</html>
