<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        Salary Advice {{ date('Y-m-d H:i:s') }}
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

<body style="">
<div class="">
    <div class="card-header" id="page">
        <div class="row" id="logo">
            <div class="col" style="padding:3% 0 0% 5%; float:left;/* position: fixed; top: 0*/">
                <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}" height="10" width="120">
            </div>
        </div>
        <div class="row" id="logo">
            <div class="col" style="text-align: center; font-weight: bold;">
                <p style="font-size: 17px;">
                    Engineering & Planning Consultants Ltd.
                </p>
                <p style="font-size: 15px;">
                    Salary and Expenses Disbursement Advice <br>
                    DIRECT DEPOSIT, BANK TRANSFER <br>
                    for the month of {{ date('F, Y', strtotime($salary_month)) }}
                </p>
            </div>
        </div>
    </div>

    <div class="card-block" style="font-size: 13px;">
        <br>
        {{--            <h6>--}}
        {{--                Dear Sir, <br> <br> We request you to transfer salary in the employees' salary account for the monthe of {{ date('F, Y') }}. <br>--}}
        {{--                Employees' detailse are given below:--}}
        {{--            </h6>--}}
        <div class="row">
            <div class="col" style="">
                <br>
                <p style="padding-left: 20px">Advice Date: </p>
                <br>
                <p style="padding-left: 20px; font-weight: bold">PROJECT: {{ isset($project_name) ? $project_name : '' }} Staff</p>
            </div>
            <div class="col" style="">
                <p>
                    Name of Bank Account:: Engineering & Planning Consultants Ltd <br>
                    Account No: 0008- 1050000891 <br>
                    Name of Bank: Midland Bank Ltd <br>
                    Branch Name: Dhanmondi Branch, Dhaka <br>
                    Routing No: 285261185
                </p>
            </div>
        </div>
        <table id="" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Name of Beneficiary same as Bank A/c</th>
                <th>Bank Name</th>
                <th>Bank Branch</th>
                <th>Bank A/c Number</th>
                <th>Routing No.</th>
                <th>Amount (TK)</th>
                <th>Remarks</th>
            </tr>
            </thead>
            <tbody>
            @php $i = 1; $total_sum = 0 @endphp
            @foreach($employees as $employee)
                @if($employee->id != 1)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$employee->first_name.' '.$employee->last_name}}</td>
                        <td>
                            @if(isset($employee->bank))
                                {{$employee->bank->bank_name}}
                            @endif
                        </td><td>
                            @if(isset($employee->bank))
                                {{$employee->bank->bank_branch}}
                            @endif
                        </td>
                        <td>
                            @if(isset($employee->bank))
                                {{$employee->bank->account_number}}
                            @endif
                        </td><td>
                            @if(isset($employee->bank))
                                {{$employee->bank->routing_no}}
                            @endif
                        </td>
                        @foreach($salaries as $salary)
                            @if($salary->employee_id == $employee->id)
                                @php $result = App\ErpEmployeeSalary::tax_certificate($employee->id, $salary_month, $salary_month, $project_id); @endphp
                            @endif
                        @endforeach
                        <td>
                            @php
                                $total_sum += $result->net_salary
                            @endphp
                            {{ $result->net_salary }}
                        </td>
                        <td></td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td></td>
                <th  colspan="5">Total amount</th>
                <th>{{ $total_sum }}</th>
                <td></td>
            </tr>
            </tbody>
            <tfoot>
            <div class="text-bottom text-right pt-5 mt-15">
                <div class="row">
                    <div class="col" style="position: fixed; bottom: 0" >
                        <p class=" " style="font-size: 12px;" >ERP Version 1.1 | Developed by: White Paper | Printed By: {{ Auth::user()->name }} | <span id="datetime"></span></p>
                    </div>
                </div>
            </div>
            </tfoot>
        </table>

    </div>

    <div class="card-footer text-bottom text-left pt-5 mt-5">
        <div class="row" style="font-size: 15px">
            @if(isset($authorizes))
                @foreach($authorizes as $authorize)
                    <div class="col">
                        <hr>
                        <p class=" ">{{ $authorize->user->name }}</p>
                        <p class=" ">{{ $authorize->user->employee->designation->designation_name }}</p>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="row">
        <div class="" style=" margin-bottom: 50px; margin-left: 50px;">
            <div class="" style="padding:3% 0 3% 5%;">
                <img class="img-fluid" src="{{asset('public/assets/images/epc_round.png')}}" height="20" width="150">
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
        // window.close();
        // history.back();
        // history.go(-1);
    });
</script>
</body>
</html>
