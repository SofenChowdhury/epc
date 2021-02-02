@extends('backEnd.master')
@section('mainContent')
    <div class="tab-pane" id="contacts" role="tabpanel">
        <div class="row">
            @can('Add Bonus and Advances')
                <div class="col-xl-12">
{{--                    <div class="tab-header card">--}}
{{--                        <ul class="nav nav-tabs nav-fill tab-timeline" role="tablist" id="mytab">--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link active tab_style" data-toggle="tab" href="#attendance" role="tab">Employee Attendance</a>--}}
{{--                                <div class="slide"></div>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link tab_style" data-toggle="tab" href="#holiday" role="tab">EPC Holiday</a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
                    <div class="tab-content">
                        <div class="tab-pane active" id="attendance" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text">Attendance  of {{ $month }}</h5>
                                </div>
                                <div class="card-block">
                                    @if( Auth::user()->getRoleNames()->first() == 'Super Admin' || Auth::user()->id == 27)
                                        {{ Form::open(['class' => '', 'files' => true, 'url' => 'employee/attendance/0', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                        {{csrf_field()}}
                                        <div class="card printBtn">
                                            <div class="card-block">
                                                <h6 style="color: blue;"> MANUAL ATTENDANCE </h6>
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <div class="form-group col-md-4">
                                                            <label for="employee_id"><span class="important">*</span> Employee Name : </label>
                                                            <select class="js-example-basic-single col-sm-12 {{ $errors->has('employee_id') ? ' is-invalid' : '' }}" name="employee_id" id="bonus_employee_id">
                                                                <option value="">Select Employee </option>
                                                                @foreach($employees as $employee)
                                                                    <option value="{{ $employee->id }} {{ old('employee_id') == $employee->id ? 'selected' : '' }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @if ( $errors->has('employee_id') )
                                                                <span class="invalid-feedback" role="alert" >
                                                                    <span class="messages"><strong>{{ $errors->first('employee_id') }}</strong></span>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <label for="attendance_date"><strong> Date:</strong></label>
                                                            <input type="" class="form-control datepicker {{ $errors->has('attendance_date') ? ' is-invalid' : '' }}" value="{{ old('attendance_date') }}" name="attendance_date" required/>
                                                            @if ($errors->has('attendance_date'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <span class="messages"><strong>{{ $errors->first('attendance_date') }}</strong></span>
                                                                </span>
                                                            @endif
                                                        </div>

                                                        <div class="form-group col-md-2">
                                                            <label for="in_time"><strong>IN Time:</strong></label>
                                                            <input type="time" class="form-control {{ $errors->has('in_time') ? ' is-invalid' : '' }}" value="{{ old('in_time') }}" name="in_time" required/>
                                                            @if ($errors->has('in_time'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <span class="messages"><strong>{{ $errors->first('in_time') }}</strong></span>
                                                            </span>
                                                            @endif
                                                        </div>

                                                        <div class="form-group col-md-2">
                                                            <label for="out_time"><strong>OUT Time:</strong></label>
                                                            <input type="time" class="form-control {{ $errors->has('out_time') ? ' is-invalid' : '' }}" value="{{ old('out_time') }}" name="out_time" required/>
                                                            @if ($errors->has('out_time'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <span class="messages"><strong>{{ $errors->first('out_time') }}</strong></span>
                                                            </span>
                                                            @endif
                                                        </div>

                                                        <div class="form-group col-md-2">
                                                            <label for="submit"></label>
                                                            <input type="submit" class="form-control btn btn-primary m-b-0" style="margin-top: 5px;" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{ Form::close()}}
                                    @endif
                                    <div class="table-responsive">
                                        <table id="excel-bg" class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Date</th>
                                                <th>Employee</th>
                                                <th>IN Time</th>
                                                <th>OUT Time</th>
                                                <th>Overtime</th>
                                                <th>Total Hours</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php $i = 1 @endphp
{{--                                            @if(isset($attendances))--}}
{{--                                                @foreach($attendances as $attendance)--}}
{{--                                                    <tr>--}}
{{--                                                        <td>{{$i++}}</td>--}}
{{--                                                        <td>{{date('F d, Y', strtotime($attendance->attendance_date))}}</td>--}}
{{--                                                        <td>--}}
{{--                                                            @if(isset($attendance->employee_id))--}}
{{--                                                                {{ $attendance->employee->first_name }} {{ $attendance->employee->last_name }}--}}
{{--                                                            @endif--}}
{{--                                                        </td>--}}
{{--                                                        <td>{{date('h:i A', strtotime($attendance->in_time))}}</td>--}}
{{--                                                        <td>{{date('h:i A', strtotime($attendance->out_time))}}</td>--}}
{{--                                                        @if(isset($attendance->overtime))--}}
{{--                                                            <td>{{date('H:i ', strtotime($attendance->overtime))}} hours</td>--}}
{{--                                                        @else--}}
{{--                                                            <td></td>--}}
{{--                                                        @endif--}}
{{--                                                        <td>{{date('H:i', strtotime($attendance->total_hours))}} hours</td>--}}
{{--                                                    </tr>--}}
{{--                                                @endforeach--}}
{{--                                            @endif--}}
                                            @if(isset($employees))
                                                @foreach($employees as $employee)
                                                    <tr>
                                                        <td>{{$i++}}</td>
                                                        <td>{{date('F d, Y', strtotime($month))}}</td>
                                                        <td>
                                                            @if(isset($employee))
                                                                {{ $employee->first_name }} {{ $employee->last_name }}
                                                            @endif
                                                        </td>
                                                        <td>{{date('h:i A', strtotime('9:00'))}}</td>
                                                        <td>{{date('h:i A', strtotime('17:00'))}}</td>
                                                        <td>{{date('H:i', strtotime('00:00'))}} hours</td>
                                                        <td>{{date('H:i', strtotime('8:00'))}} hours</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="text-bottom text-center pt-5 mt-5 footer" style="display: none" id="footer">
                                <div class="row">
                                    <div class="col">
                                        <p style="font-size: 0.9rem; background-color: #ece7e4;" >ERP Version 1.1 | Developed by: White Paper | Printed By: {{ Auth::user()->name }} | <span id="datetime1"> </p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane" id="holiday" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text">EPC Holiday</h5>
                                </div>
                                <div class="card-block">
                                    {{ Form::open(['class' => '', 'files' => true, 'url' => 'addAdvance', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="employee_id"><span class="important">*</span> Employee Name : </label>
                                            <select class="js-example-basic-single col-sm-12 {{ $errors->has('employee_id') ? ' is-invalid' : '' }}" name="employee_id" id="advance_employee_id">
                                                <option value="">Select Employee </option>
                                                @foreach($employees as $employee)
                                                    <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                                @endforeach
                                            </select>
                                            @if ( $errors->has('employee_id') )
                                                <span class="invalid-feedback" role="alert" >
                                            <span class="messages"><strong>{{ $errors->first('employee_id') }}</strong></span>
                                        </span>
                                            @endif
                                        </div>

                                        {{--                                <div class="form-group col-md-6">--}}
                                        {{--                                    <label for="salary">Basic Salary :</label>--}}
                                        {{--                                    <input type="number" class="form-control {{ $errors->has('salary') ? ' is-invalid' : '' }}" value="{{ old('salary') }}" name="salary" readonly id="advance_salary"/>--}}
                                        {{--                                    @if ($errors->has('salary'))--}}
                                        {{--                                        <span class="invalid-feedback" role="alert" >--}}
                                        {{--                                            <span class="messages"><strong>{{ $errors->first('salary') }}</strong></span>--}}
                                        {{--                                        </span>--}}
                                        {{--                                    @endif--}}
                                        {{--                                </div>--}}
                                        <div class="form-group col-md-6">
                                            <label for="amount">Amount :</label>
                                            <input type="number" class="form-control {{ $errors->has('amount') ? ' is-invalid' : '' }}" value="{{ old('amount') }}" name="amount" id="advance_amount"/>
                                            @if ($errors->has('amount'))
                                                <span class="invalid-feedback" role="alert" >
                                            <span class="messages"><strong>{{ $errors->first('amount') }}</strong></span>
                                        </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="repay_duration">Repay Duration (No. of Months):</label>
                                            <select class="js-example-basic-single col-sm-12 {{ $errors->has('repay_duration') ? ' is-invalid' : '' }}" name="repay_duration">
                                                <option value="">Select Duration </option>
                                                <option value="3">3 months </option>
                                                <option value="6">6 months </option>
                                                <option value="9">9 months </option>
                                                <option value="12">12 months </option>
                                            </select>
                                            @if ($errors->has('repay_duration'))
                                                <span class="invalid-feedback" role="alert" >
                                            <span class="messages"><strong>{{ $errors->first('repay_duration') }}</strong></span>
                                        </span>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="description">Comments :</label>
                                            <textarea class="form-control" value="{{ old('description') }}" name="description"></textarea>
                                            @if ( $errors->has('description') )
                                                <span class="invalid-feedback" role="alert" >
                                            <span class="messages"><strong>{{ $errors->first('description') }}</strong></span>
                                        </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row mt-5">
                                        <div class="col-sm-6 text-center" style="margin-bottom: 1em;">
                                            <a class="" title="cancel" href="{{url('/employee')}}">
                                                <button type="button" class="btn btn-primary m-b-0">Cancel</button>
                                            </a>
                                        </div>
                                        <div class="col-sm-6 text-center">
                                            <button type="submit" class="btn btn-primary m-b-0">Submit</button>
                                        </div>
                                    </div>
                                    {{Form::close()}}
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

@endsection
