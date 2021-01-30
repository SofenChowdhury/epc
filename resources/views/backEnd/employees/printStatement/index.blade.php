@extends('backEnd.master')
@section('mainContent')
    @if(session()->has('message-success'))
        <div class="alert alert-success mb-3 background-success" role="alert">
            {{ session()->get('message-success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @elseif(session()->has('message-danger'))
        <div class="alert alert-danger">
            {{ session()->get('message-danger') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session()->has('message-success-delete'))
        <div class="alert alert-danger mb-3 background-danger" role="alert">
            {{ session()->get('message-success-delete') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @elseif(session()->has('message-danger-delete'))
        <div class="alert alert-danger">
            {{ session()->get('message-danger-delete') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="tab-pane" id="contacts" role="tabpanel">
        <div class="row">
            @can('Add Bonus and Advances')
                <div class="col-xl-12">
                    <div class="tab-header card">
                        <ul class="nav nav-tabs nav-fill tab-timeline" role="tablist" id="mytab">
                            <li class="nav-item">
                                <a class="nav-link active tab_style" data-toggle="tab" href="#statement" role="tab" onclick="actDiv('0')">Salary Statement</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link tab_style" data-toggle="tab" href="#advice" role="tab" onclick="actDiv('1')">Salary Advice</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        @if($activeDiv == 1)
                            <div class="tab-pane" id="statement" role="tabpanel">
                        @else
                            <div class="tab-pane active" id="statement" role="tabpanel">
                        @endif
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text">Salary Statement</h5>
                                    {{ Form::open(['class' => '', 'files' => true, 'url' => 'employee/printSalary', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                    <input type="text" name="salary_month" value="{{ $salary_month }}" hidden>
                                    <input type="text" name="project_id" value="{{ isset($project_selected) ? $project_selected : 0 }}" hidden>
                                    <button type="submit" class="btn btn-success m-b-0" style="float: right; padding: 8px; color: white;" formtarget="_blank">Print Statement</button>
                                    {{ Form::close()}}
                                </div>
                                <div class="card-block">
                                    <div class="card">
                                        {{ Form::open(['class' => '', 'files' => true, 'url' => 'employee/statement', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                        <div class="row input-daterange mb-3 mt-3" width="80%">
                                            <div class="col-md-4 offset-md-1">
                                                <input type="text" class="form-control datepicker" name="auto_date" value="{{ $salary_month }}" hidden>
                                                <input type="text" aria-invalid="datepicker" class="form-control datepicker" name="salary_month" placeholder="Salary Statement for Month {{ date('F, Y', strtotime($salary_month)) }}" readonly autocomplete="off"/>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="js-example-basic-single  {{ $errors->has('project_id') ? ' is-invalid' : '' }}" name="project_id" id="project_id">
                                                    <option value="0" {{ isset($project_selected) && $project_selected == 0 ? 'selected' : ''  }}>Head Office</option>
                                                    @foreach($projects as $project)
                                                        <option value="{{ $project->id }}" {{ isset($project_selected) && $project_selected == $project->id ? 'selected' : ''  }}>{{ $project->project_name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2 col-sm-6 pt-1">
                                                <input type="hidden" name="active_div" value="0">
                                                <button type="submit" class="btn btn-primary" style="float: right; padding: 6px 50px;">Filter</button>
                                            </div>
                                        </div>
                                        {{ Form::close() }}
                                    </div>
                                    <div class="table-responsive">
                                        <table id="basic-btn" class="table table-striped table-bordered">
                                            <thead>
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
                                                <th>Total Bonus</th>

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
                                                @php $money = $present_salary = $amount = $advance_amount = $tax_payable = $gross = 0 @endphp
                                                @if( $employee->unique_id != 'H001-0719-01' || $employee->unique_id != '00224')
                                                    @php
                                                        $result = App\ErpEmployeeSalary::tax_certificate($employee->id, $salary_month, $salary_month, $project_selected);
                                                        $project_count = App\ErpProjectEmployee::projects_working($employee->id);
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
                                                                        1{{ $result->holidays }}
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
                                                                    @php $attended = $working @endphp
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
                                                            @php
                                                                $result->net_salary = $result->conveyance + $result->gross;
                                                                $result->net_salary -= $result->tax_payable;
                                                                $result->net_salary -= $result->advance;
                                                                $total_sum += $result->net_salary;
                                                            @endphp
                                                            {{ $result->net_salary }}
                                                        </td>
                                                        <td>{{$employee->type->type_name}}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                @php
                                    $first_authorizer = 1;
                                    if(isset($authorizes)){
                                        foreach($authorizes as $authorize){
                                            if($authorize->serial_no == 1)
                                                $first_authorizer = $authorize->user_id;
                                        }
                                    }
                                @endphp

                                @if(!isset($approver) && Auth::user()->id == $first_authorizer)
                                    <div class="card-block text-center">
                                        {{ Form::open(['class' => '', 'files' => true, 'url' => 'statement/approve', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                        <input type="text" name="salary_month" value="{{ $salary_month }}" hidden>
                                        <input type="text" name="project_id" value="{{ isset($project_selected) ? $project_selected : 0 }}" hidden>
                                        <input type="text" name="new_statement" value="1" hidden>
                                        <button type="submit" class="btn btn-success m-b-0" name="permission" value="1">Approve</button>
                                        {{ Form::close()}}
                                    </div>

                                @elseif(isset($approver) && Auth::user()->id == $first_authorizer && $approver->approval_level != 5)
                                    <div class="card-block text-center">
                                        {{ Form::open(['class' => '', 'files' => true, 'url' => 'statement/approve', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                        <input type="text" name="salary_month" value="{{ $salary_month }}" hidden>
                                        <input type="text" name="project_id" value="{{ isset($project_selected) ? $project_selected : 0 }}" hidden>
                                        <button type="submit" class="btn btn-danger m-b-0" name="permission" value="0">Recall</button>
                                        {{ Form::close()}}
                                    </div>
                                @endif

                                @if(isset($approver))
                                    @if(Auth::user()->id == $approver->next_user_id)
                                        <div class="card-block text-center">
                                            {{ Form::open(['class' => '', 'files' => true, 'url' => 'statement/approve', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                            <button type="submit" class="btn btn-success m-b-0" name="permission" value="1">Approve</button>
                                            <button type="submit" class="btn btn-primary m-b-0" name="permission" value="0">Reject</button>
                                            <input type="text" name="salary_month" value="{{ $salary_month }}" hidden>
                                            <input type="text" name="project_id" value="{{ isset($project_selected) ? $project_selected : 0 }}" hidden>
                                            {{ Form::close()}}
                                        </div>
                                    @endif
                                @endif

                                <div class="card-block text-left pt-5">
                                    <div class="row">
                                        @if(isset($authorizes))
                                            @foreach($authorizes as $authorize)
                                                <div class="col">
                                                    @if(isset($approver) && $approver->approval_level >= $authorize->serial_no)
                                                        <button type="button" class="btn btn-success action-icon text-center">Approved</button>
                                                    @else
                                                        <p></p>
                                                    @endif
                                                    <hr>
                                                    <p class=" ">{{ $authorize->user->name }}</p>
                                                    <p class=" ">{{ $authorize->user->employee->designation->designation_name }}</p>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($activeDiv == 1)
                            <div class="tab-pane active" id="advice" role="tabpanel">
                        @else
                            <div class="tab-pane" id="advice" role="tabpanel">
                        @endif
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text">Salary Advice</h5>
{{--                                    @if(isset($approver) && $approver->approval_level == 5)--}}
                                    {{ Form::open(['class' => '', 'files' => true, 'url' => 'employee/printSalary2', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                        <input type="text" name="salary_month" value="{{ $salary_month }}" hidden>
                                        <input type="text" name="project_id" value="{{ isset($project_selected) ? $project_selected : 0 }}" hidden>
                                        <button type="submit" class="btn btn-success m-b-0" style="float: right; padding: 8px; color: white;" formtarget="_blank">Print Salary Advice</button>
                                    {{ Form::close()}}
{{--                                    @endif--}}
                                </div>
                                <div class="card-block">
                                    <div class="card">
                                        {{ Form::open(['class' => '', 'files' => true, 'url' => 'employee/statement', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                        <div class="row input-daterange mb-3 mt-3" width="80%">
                                            <div class="col-md-4 offset-md-1">
                                                <input type="text" class="form-control datepicker" name="auto_date" value="{{ $salary_month }}" hidden>
                                                <input type="text" aria-invalid="datepicker" class="form-control datepicker" data-date-format="m-Y" name="salary_month" placeholder="Salary Statement for Month {{ date('F, Y', strtotime($salary_month)) }}" readonly autocomplete="off"/>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="js-example-basic-single  {{ $errors->has('project_id') ? ' is-invalid' : '' }}" name="project_id" id="project_id">
                                                    <option value="0" {{ old('project_id')== 'head' ? 'selected' : ''  }}>Head Office</option>
                                                    @foreach($projects as $project)
                                                        <option value="{{ $project->id }}" {{ isset($project_selected) && $project_selected == $project->id ? 'selected' : ''  }}>{{ $project->project_name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2 col-sm-6 pt-1">
                                                <input type="hidden" name="active_div" value="1" id="active_div">
                                                <button type="submit" class="btn btn-primary" style="float: right; padding: 6px 50px;">Filter</button>
                                            </div>
                                        </div>
                                        {{ Form::close() }}
                                    </div>
                                    <div class="table-responsive">
{{--                                    @if(isset($approver) && $approver->approval_level == 5)--}}
                                    <table id="advice_table" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Name of Beneficiary same as Bank A/c</th>
                                            <th>Bank Name</th>
                                            <th>Branch Name</th>
                                            <th>Bank A/c Number</th>
                                            <th>Routing No.</th>
                                            <th>Amount in Taka</th>
                                            <th>Remarks</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $i = 1; $total_sum = 0; @endphp
                                        @foreach($employees as $employee)
                                            @php $money = $amount = $advance_amount = $gross = $present_salary = 0 @endphp
                                            @if($employee->unique_id != 'H001-0719-01' || $employee->unique_id != '00224')
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{$employee->first_name.' '.$employee->last_name}}</td>
                                                    <td>
                                                        @if(isset($employee->bank))
                                                            {{$employee->bank->bank_name}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(isset($employee->bank))
                                                            {{$employee->bank->bank_branch}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(isset($employee->bank))
                                                            {{$employee->bank->account_number}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(isset($employee->bank))
                                                            {{$employee->bank->routing_no}}
                                                        @endif
                                                    </td>
                                                    @foreach($salaries as $salary)
                                                        @if($salary->employee_id == $employee->id)
                                                            @php $result = App\ErpEmployeeSalary::tax_certificate($employee->id, $salary_month, $salary_month, $project_selected); @endphp
                                                        @endif
                                                    @endforeach
                                                    <td>
                                                        @php
                                                            $result->net_salary = $result->conveyance + $result->gross;
                                                            $result->net_salary -= $result->tax_payable;
                                                            $result->net_salary -= $result->advance;
                                                            $total_sum += $result->net_salary;
                                                        @endphp
                                                        {{ $result->net_salary }}
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr>
                                            <th>SL</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Total Taka = </th>
                                            <th>{{$total_sum}}</th>
                                            <th></th>
                                        </tr>
                                        </tbody>
                                    </table>
{{--                                    @endif--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    </div>
@endSection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#advice_table').DataTable();
        } );
        // function actDiv(id){
        //     $('#active_div').val(id);
        // }
    </script>
@endsection
