<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        Salary Statement {{ date('Y-m-d H:i:s') }}
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
    <div class="row" id="logo" style=" margin-bottom: 50px">
        <div class="" style="padding:3% 0 3% 5%; display: table-header-group /*position: fixed; top: 0;*/">
            <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}" height="10" width="120">
{{--            <p style="margin-top: 15px; font-size: 14px; font-weight: bold;">{{ $setup->company_name }}</p>--}}
        </div>
        <div class="" style="text-align: center; font-weight: bold; padding:3% 0 3% 20%; /*position: fixed; top: 20px;*/">
            <p style="margin-top: 15px; font-size: 20px; ">Monthly Salary Statement of <br> {{ date('F, Y', strtotime($salary_month)) }}</p>
        </div>
    </div>

    <div class="row" >
        <div class="">
            <p style="font-weight: bolder">{{ isset($project_name) ? $project_name : '' }}</p>
            <table id="" class="table table-striped table-bordered" border="1">
                <thead>
                <tr style="text-align: center">
                    <th colspan="4">Employee</th>
                    <th colspan="4">Approved Salary</th>
                    <th colspan="10">Attendance/ Leave Information</th>
                    <th colspan="5">Overtime</th>
                    <th colspan="6">Bonus</th>
                    <th colspan="4">Net Income - Deductibles</th>
                    <th></th>
                </tr>
                <tr>
                    <th>SL</th>
                    <th>Employee ID</th>
                    <th>Full Name</th>
                    <th>Designation</th>

                    <th>Gross Salary</th>
                    <th>Basic Salary</th>
                    <th>Hourly Rate</th>
                    <th>Overtime Hourly Rate</th>

                    <th>Monthly Total Week Days</th>
                    <th>EPC Holidays</th>
                    <th>Calculated Working Days</th>
                    <th>Days Worked</th>
                    <th>Earned Leave</th>
                    <th>Sick leave</th>
                    <th>Special Leave</th>
                    <th>Leave W/O Pay</th>
                    <th>Net Working Days</th>
                    <th>Net Salary</th>

                    <th>Overtime Hrs</th>
                    <th>Overtime Conveyance</th>
                    <th>Overtime Food</th>
                    <th>Overtime Pay</th>
                    <th>Overtime Total</th>

                    <th>Eid Bonus</th>
                    <th>Annual Bonus</th>
                    <th>Transport Allowance </th>
                    <th>Mobile Allowance </th>
                    <th>Other Bonus</th>
                    <th>Total</th>

                    <th>Gross Payment</th>
                    <th>Conveyance Add</th>
                    <th>Income Tax Deduc</th>
                    <th>Advance Deduc</th>
                    <th>Net Payment</th>

                    <th>Remarks</th>
                </tr>
                </thead>
                <tbody>
                @php $i = 1; $total_sum = 0 @endphp
                @foreach($employees as $employee)
                    @if($employee->id != 1)
                        @php
                            $result = App\ErpEmployeeSalary::tax_certificate($employee->id, $salary_month, $salary_month, $project_id);
                            $project_count = 0;
                            $connected = App\ErpProjectEmployee::projects_working($employee->id);
                            if ($connected)
                                $project_count = $connected;
                        @endphp
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$employee->unique_id}}</td>
                            <td>{{$employee->first_name.' '.$employee->last_name}}</td>
                            <td>
                                @if(isset($employee->designation_id))
                                    {{$employee->designation->designation_name}}
                                @endif
                            </td>
                            @foreach($salaries as $salary)
                                @if($salary->employee_id == $employee->id)
                                    <td>
                                        @if( isset($result) )
                                            {{ $result->present_salary }}
                                        @else

                                        @endif
                                    </td>
                                    <td>
                                        @if( isset($result->basic) )
                                            {{ $result->basic }}
                                        @else

                                        @endif
                                    </td>
                                    @php $hourly_rate = ceil(App\ErpEmployeeSalary::hourly_calc($employee->id)); @endphp
                                    <td>
                                        @if( isset($hourly_rate) )
                                            {{ $hourly_rate }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @if( isset($hourly_rate) )
                                            @php $overtime_rate = $hourly_rate * 1 @endphp
                                            {{ $overtime_rate }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @if( isset($result->weekdays) )
                                            {{ $result->weekdays }}
                                        @else
                                        @endif
                                    </td>
                                    <td>
                                        @if( isset($result->holidays) )
                                            {{ $result->holidays }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @if( isset($result))
                                            @php $working = $result->weekdays - $result->holidays @endphp
                                            {{ $working }}
                                        @else
                                        @endif
                                    </td>
                                    <td>
                                        @php $attended = App\ErpEmployeeAttendance::attendance_calc($employee->id, $salary_month); @endphp
                                        @php $attended = $working @endphp {{--comment_out_this_line--}}
                                        @if( isset($attended) )
                                            {{ $attended }}
                                            @php $working_with_leave = $attended @endphp
                                        @else

                                        @endif
                                    </td>

                                    <td>
                                        @if( isset($earned_leave) )
                                            {{ $earned_leave }}
                                            @php $working_with_leave -= $earned_leave @endphp
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @if( isset($sick_leave) )
                                            {{ $sick_leave }}
                                            @php $working_with_leave -= $sick_leave @endphp
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @if( isset($special_leave) )
                                            {{ $special_leave }}
                                            @php $working_with_leave -= $special_leave @endphp
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @if( isset($unpaid_leave) )
                                            {{ $unpaid_leave }}
                                            @php $working_with_leave -= $unpaid_leave @endphp
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @if( isset($working_with_leave) )
                                            {{ $working_with_leave }}
                                        @else

                                        @endif
                                    </td>
                                    <td>
                                        @if( isset($result))
                                            {{ $result->present_salary }}
                                        @else
                                        @endif
                                    </td>

                                    @php $overtime = App\ErpEmployeeAttendance::overtime_calc($employee->id, $salary_month); @endphp
                                    <td>
                                        @if( isset($overtime) )
                                            {{ $overtime->overtime_hours }}
                                        @else
                                        @endif
                                    </td>
                                    <td>{{ $result->ot_conveyance }}</td>
                                    <td>{{ $result->ot_food }}</td>
                                    <td>{{ $result->ot_pay }}</td>
                                    <td>{{ $result->overtime }}</td>

                                    <td>{{ $result->eid_bonus }}</td>
                                    <td>{{ $result->annual_bonus }}</td>
                                    <td>{{ $result->transport_allowance }}</td>
                                    <td>{{ $result->mobile_allowance }}</td>
                                    <td>{{ $result->other_allowance }}</td>
                                    <td>{{ $result->bonus }}</td>

                                    <td>{{ $result->gross }}</td>
                                @endif
                            @endforeach
                            <td>{{ $result->conveyance }}</td>
                            <td>{{ $result->tax_payable }}</td>
                            <td>{{ $result->advance }}</td>
                            <td>
                                @php $total_sum += $result->net_salary @endphp
                                {{ $result->net_salary }}
                            </td>
                            <td></td>
                        </tr>
                    @endif
                @endforeach
                    <tr>
                        <td colspan="2"></td>
                        <th colspan="31">Total amount</th>
                        <th>{{ $total_sum }}</th>
                        <td></td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>

<div class="text-bottom text-left pt-5 mt-5">
    <div class="row">
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

<div class="text-bottom text-right pt-5 mt-15 divFooter">
    <div class="row">
        <div class="" style=" margin-bottom: 50px; margin-left: 50px;">
            <div class="" style="padding:3% 0 3% 15%;">
                <img class="img-fluid" src="{{asset('public/assets/images/epc_round.png')}}" height="20" width="150">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col" style="position: fixed; bottom: 0">
            <p class=" " style="font-size: 0.9em;" >ERP Version 1.1 | Developed by: White Paper | Printed By: {{ Auth::user()->name }} | <span id="datetime"></span></p>
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
