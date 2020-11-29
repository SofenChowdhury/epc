<div class="tab-pane" id="financial" role="tabpanel">
    <div class="tab-pane" role="tabpanel">
        <div class="row">
            <div class="col-xl-12">
                @if($editData->project_phase >= 3)
                    <div class="tab-header card">
                        <ul class="nav nav-tabs nav-fill tab-timeline" role="tablist" id="myinnertab">
                            @can('view Project Employee List')
                                <li class="nav-item">
                                    <a class="nav-link active tab_style" data-toggle="tab" href="#employees" role="tab">Remuneration
                                        Expenses</a>
                                    <div class="slide"></div>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link tab_style" data-toggle="tab" href="#budget" role="tab">Reimbursable
                                        Expenses</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link tab_style" data-toggle="tab" href="#advance" role="tab">Advance
                                        Payment</a>
                                </li>
                                @if($editData->project_phase >= 3)

                                    <li class="nav-item">
                                        <a class="nav-link tab_style" data-toggle="tab" href="#progress" role="tab">Progress
                                            Payment</a>
                                    </li>
                                @endif

                            @endcan
                        </ul>
                    </div>
                @endif

                <div class="tab-content">
                    <div class="tab-pane active" id="employees" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                @if( isset($editData->project_name) )
                                    <h5 class="card-header-text"
                                        style="font-size: 1rem;">{{ $editData->project_name }}</h5>
                                @else
                                    <h5 class="card-header-text">No Project Name</h5>
                                @endif
                                <button class="btn btn-success printBtn"
                                        onclick="printEmployeesDiv('project_employees')"
                                        style="float: right; padding: 10px;" target="_blank">Print Employees List
                                </button>
                                <a href="{{ url('project/remuneration/amendment/create',$editData->id) }}"
                                   style="float: right; padding: 10px; color: white;margin-right: 10px"
                                   class="btn btn-success"> Add Amendment </a>
                            </div>
                            <div class="card-block">
                                <div class="card">
                                    <div class="card-block">
                                        {{ Form::open(['class' => '', 'files' => true, 'url' => 'project/employee/'.$editData->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                        {{csrf_field()}}

                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="employee"><strong> Amendment No:</strong></label>
                                                <select
                                                    class="js-example-basic-single col-sm-12 {{ $errors->has('amendment') ? ' is-invalid' : '' }}"
                                                    name="amendment" id="amendment">
                                                    <option value="">Select Amendment No</option>
                                                    @if($maxAmendment>0)
                                                        @for($ky=1; $ky<=$maxAmendment; $ky++)
                                                            <option
                                                                value="{{ $ky}}">{{$ky}}</option>
                                                        @endfor
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group row col-md-12">
                                                <div class="form-group col-md-3">
                                                    <label for="employee"><strong> Employee Name:</strong></label>
                                                    <select
                                                        class="js-example-basic-single col-sm-12 {{ $errors->has('employee') ? ' is-invalid' : '' }}"
                                                        name="employee" id="employee">
                                                        <option value="">Select Employee</option>
                                                        @if(isset($employees))
                                                            @foreach($employees as $employee)
                                                                <option
                                                                    value="{{ $employee->id }}" {{ old('employee')== $employee->id ? 'selected' : ''  }}>{{$employee->unique_id}}
                                                                    . {{$employee->first_name}} {{$employee->last_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-3">
                                                    <label for="title"><strong>Position:</strong></label>
                                                    <input type="text"
                                                           class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}"
                                                           value="{{ old('title') }}" name="title"/>
                                                    @if ($errors->has('title'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <span
                                                                class="messages"><strong>{{ $errors->first('title') }}</strong></span>
                                                        </span>
                                                    @endif
                                                </div>

                                                @if($editData->project_phase < 3)
                                                    <div class="form-group col-md-3">
                                                        <label for="man_hour"><strong><span class="important">*</span>
                                                                Man hour:</strong></label>
                                                        <input type="number"
                                                               step="0.01"
                                                               class="form-control {{ $errors->has('man_hour') ? ' is-invalid' : '' }}"
                                                               value="{{ old('man_hour') }}" name="man_hour" required/>
                                                        @if ($errors->has('man_hour'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <span
                                                                    class="messages"><strong>{{ $errors->first('man_hour') }}</strong></span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="form-group col-md-2">
                                                        <label for="staff_month_rate"><strong><span
                                                                    class="important">*</span> Staff Month
                                                                Rate:</strong></label>
                                                        <input type="number"
                                                               step="0.01"
                                                               class="form-control {{ $errors->has('staff_month_rate') ? ' is-invalid' : '' }}"
                                                               value="{{ old('staff_month_rate') }}"
                                                               name="staff_month_rate" required/>
                                                        @if ($errors->has('staff_month_rate'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <span
                                                                    class="messages"><strong>{{ $errors->first('staff_month_rate') }}</strong></span>
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group col-md-2">
                                                        <label for="staff_month_proposal"><strong><span
                                                                    class="important">*</span> Staff
                                                                month(Proposal):</strong></label>
                                                        <input type="number"
                                                               step="0.01"
                                                               class="form-control {{ $errors->has('staff_month_proposal') ? ' is-invalid' : '' }}"
                                                               value="{{ old('staff_month_proposal') }}"
                                                               name="staff_month_proposal" required/>
                                                        @if ($errors->has('staff_month_proposal'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <span
                                                                    class="messages"><strong>{{ $errors->first('staff_month_proposal') }}</strong></span>
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group col-md-2">
                                                        <label for="staff_month_agreed"><strong><span class="important">*</span>
                                                                Staff month(Agreed):</strong></label>
                                                        <input type="number"
                                                               step="0.01"
                                                               class="form-control {{ $errors->has('staff_month_agreed') ? ' is-invalid' : '' }}"
                                                               value="{{ old('staff_month_agreed') }}"
                                                               name="staff_month_agreed" required/>
                                                        @if ($errors->has('staff_month_agreed'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <span
                                                                    class="messages"><strong>{{ $errors->first('staff_month_agreed') }}</strong></span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="collapse row col-md-12" id="add_emp">
                                                @for($i=1; $i<=4; $i++)
                                                    <div class="form-group row col-md-12">
                                                        <div class="form-group col-md-3">
                                                            <label for="employee"><strong> Employee Name:</strong></label>
                                                            <select class="js-example-basic-single col-sm-12 {{ $errors->has('employee') ? ' is-invalid' : '' }}" name="employee_{{$i}}" id="employee">
                                                                <option value="">Select Employee</option>
                                                                @if(isset($employees))
                                                                    @foreach($employees as $employee)
                                                                        <option value="{{ $employee->id }}"  {{ old('employee')== $employee->id ? 'selected' : ''  }}>{{$employee->unique_id}} . {{$employee->first_name}} {{$employee->last_name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-md-3">
                                                            <label for="title"><strong>Position:</strong></label>
                                                            <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}" name="title_{{$i}}"/>
                                                            @if ($errors->has('title'))
                                                                <span class="invalid-feedback" role="alert">
                                                        <span
                                                            class="messages"><strong>{{ $errors->first('title') }}</strong></span>
                                                    </span>
                                                            @endif
                                                        </div>

                                                        @if($editData->project_phase < 3)
                                                            <div class="form-group col-md-3">
                                                                <label for="man_hour"><strong><span
                                                                            class="important">*</span> Man
                                                                        hour:</strong></label>
                                                                <input type="number" step="0.01"
                                                                       class="form-control {{ $errors->has('man_hour') ? ' is-invalid' : '' }}"
                                                                       value="{{ old('man_hour') }}"
                                                                       name="man_hour_{{$i}}"/>
                                                                @if ($errors->has('man_hour'))
                                                                    <span class="invalid-feedback" role="alert">
                                                            <span
                                                                class="messages"><strong>{{ $errors->first('man_hour') }}</strong></span>
                                                        </span>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <div class="form-group col-md-2">
                                                                <label for="staff_month_rate"><strong><span
                                                                            class="important">*</span> Staff Month Rate:</strong></label>
                                                                <input type="number" step="0.01"
                                                                       class="form-control {{ $errors->has('staff_month_rate') ? ' is-invalid' : '' }}"
                                                                       value="{{ old('staff_month_rate') }}"
                                                                       name="staff_month_rate_{{$i}}"/>
                                                                @if ($errors->has('staff_month_rate'))
                                                                    <span class="invalid-feedback" role="alert">
                                                            <span
                                                                class="messages"><strong>{{ $errors->first('staff_month_rate') }}</strong></span>
                                                        </span>
                                                                @endif
                                                            </div>

                                                            <div class="form-group col-md-2">
                                                                <label for="staff_month_proposal"><strong><span
                                                                            class="important">*</span> Staff
                                                                        month(Proposal):</strong></label>
                                                                <input type="number" step="0.01"
                                                                       class="form-control {{ $errors->has('staff_month_proposal') ? ' is-invalid' : '' }}"
                                                                       value="{{ old('staff_month_proposal') }}"
                                                                       name="staff_month_proposal_{{$i}}"/>
                                                                @if ($errors->has('staff_month_proposal'))
                                                                    <span class="invalid-feedback" role="alert">
                                                            <span
                                                                class="messages"><strong>{{ $errors->first('staff_month_proposal') }}</strong></span>
                                                        </span>
                                                                @endif
                                                            </div>

                                                            <div class="form-group col-md-2">
                                                                <label for="staff_month_agreed"><strong><span
                                                                            class="important">*</span> Staff
                                                                        month(Agreed):</strong></label>
                                                                <input type="number" step="0.01"
                                                                       class="form-control {{ $errors->has('staff_month_agreed') ? ' is-invalid' : '' }}"
                                                                       value="{{ old('staff_month_agreed') }}"
                                                                       name="staff_month_agreed_{{$i}}"/>
                                                                @if ($errors->has('staff_month_agreed'))
                                                                    <span class="invalid-feedback" role="alert">
                                                            <span
                                                                class="messages"><strong>{{ $errors->first('staff_month_agreed') }}</strong></span>
                                                        </span>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endfor
                                            </div>

                                            <div class="form-group row col-md-12">
                                                <div class="form-group col-md-2">
                                                    <label for="add"></label>
                                                    <a href="#add_emp"
                                                       class="form-control btn btn-primary m-b-0 collapsible"
                                                       data-toggle="collapse" style="margin-top: 5px; color: white;">Add
                                                        Row</a>
                                                </div>

                                                <div class="form-group col-md-2">
                                                    <label for="submit"></label>
                                                    <input type="submit" class="form-control btn btn-primary m-b-0"
                                                           style="margin-top: 5px;"/>
                                                </div>
                                            </div>
                                        </div>
                                        {{ Form::close()}}
                                    </div>
                                </div>

                                <div class="card" id="project_employees">
                                    <div class="logo row" id="logo" style="display:none;">
                                        <div class="col-md-4"
                                             style="padding-left:5%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
                                            <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}"
                                                 height="10" width="120">
                                        </div>
                                        <div class="col-md-4"
                                             style="padding-left:5%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
                                            <p style="margin-top: 25px; font-size: 22px; font-weight: bold;">{{ $editData->project_name }}
                                                Project Employees List</p>
                                        </div>
                                    </div>
                                    @if(isset($distinct_employee_phase))
                                        @foreach( $distinct_employee_phase as $distinct_phase)

                                            <div class="card-block">


                                                <div class="card">
                                                    <div class="card-header">
                                                        <strong>
                                                            @foreach($phases as $phase)
                                                                @if( $distinct_phase->project_phase == $phase->defined_id )
                                                                    PHASE -
                                                                    00{{$phase->defined_id}} {{$phase->name}}
                                                                @endif
                                                            @endforeach
                                                        </strong>
                                                    </div>
                                                    @if($distinct_phase->amendment != 0)
                                                        <div class="card-header">

                                                            <strong style="color: #00aeef">
                                                                Amendment No: {{$distinct_phase->amendment}}
                                                            </strong>

                                                        </div>
                                                    @endif
                                                    @if($distinct_phase->amendment == 0)
                                                        <div class="card-header">

                                                            <strong style="color: #00aeef">
                                                                Original Contract
                                                            </strong>

                                                        </div>
                                                    @endif
                                                    <div class="card-block">
                                                        <div class="table-responsive">
                                                            <table id="project_employee"
                                                                   class="table table-striped table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>SL.</th>
                                                                    <th>Employee ID</th>
                                                                    <th>Employee Name</th>
                                                                    <th>Position</th>
                                                                    @if($distinct_phase->project_phase < 3 )
                                                                        <th>Man Hour</th>
                                                                        <th>Hourly Rate</th>
                                                                    @else
                                                                        <th>Staff Month <br> Rate</th>
                                                                        <th>Staff Month <br> (Proposed)</th>
                                                                        <th>Staff Month <br> (Agreed)</th>
                                                                    @endif
                                                                    <th>Total Amount</th>
                                                                    <th>Added By</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @php $i = 1; $total_hour = 0; $total_input = 0; $total_amount = 0;$checking = 0; @endphp
                                                                <!-- SHOW ALL EMPLOYEES OF THIS PROJECT -->
                                                                @if(isset($project_employees))
                                                                    @foreach($project_employees as $project_employee)
                                                                        @if($project_employee->project_phase == $distinct_phase->project_phase && $project_employee->amendment==$distinct_phase->amendment)

                                                                            @if($project_employee->is_amendment==1)
                                                                                <div style="display: none">
                                                                                    {{$checking=1}}
                                                                                </div>

                                                                            @endif


                                                                            <tr>
                                                                                <td> {{$i++}} </td>
                                                                                <td>
                                                                                    @if(isset($project_employee->employee_id))
                                                                                        {{ $project_employee->employee->unique_id }}
                                                                                    @endif
                                                                                </td>
                                                                                <td>
                                                                                    @if(isset($project_employee->employee_id))
                                                                                        {{ $project_employee->employee->first_name }} {{ $project_employee->employee->last_name }}
                                                                                    @endif
                                                                                </td>
                                                                                <td> {{ $project_employee->title }}</td>
                                                                                @if($distinct_phase->project_phase < 3 )
                                                                                    <td> {{ $project_employee->man_hour }}</td>
                                                                                    @php $total_hour += $project_employee->man_hour; @endphp
                                                                                    <td>
                                                                                        @foreach( $salaries as $salary )
                                                                                            @if( $project_employee->employee_id == $salary->employee_id)
                                                                                                {{ $salary->hourly_rate }}
                                                                                                @php $rate = $salary->hourly_rate @endphp
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </td>
                                                                                    <td>
                                                                                        @php $total_rate = $project_employee->man_hour*$rate; $total_amount += $total_rate; @endphp
                                                                                        {{ $total_rate }}
                                                                                    </td>
                                                                                @else
                                                                                    <td> {{ $project_employee->staff_month_rate	 }}</td>
                                                                                    <td> {{ $project_employee->staff_month_proposal }}</td>
                                                                                    <td> {{ $project_employee->staff_month_agreed }}</td>
                                                                                    @php $total_hour += $project_employee->staff_month_agreed; @endphp
                                                                                    @php $total_rate = $project_employee->staff_month_rate*$project_employee->staff_month_agreed; @endphp
                                                                                    @php $total_amount += $total_rate; @endphp
                                                                                    <td> {{ $total_rate }}</td>
                                                                                @endif
                                                                                <td>
                                                                                    @foreach( $users as $user )
                                                                                        @if( $project_employee->created_by == $user->id)
                                                                                            {{ $user->name }}
                                                                                        @endif
                                                                                    @endforeach
                                                                                </td>
                                                                                @if(isset($project_employee->reassign))
                                                                                    <td style="color: #711c1c;">
                                                                                        Reassigned to <br>
                                                                                        @if($project_employee->reassign == 0)
                                                                                            Head Office
                                                                                        @else {{ $project_employee->ressign_project->project_name }}
                                                                                        @endif
                                                                                    </td>
                                                                                @else
                                                                                    <td>
                                                                                        {{--                                                                                    SHOW EMPLOYEE--}}
                                                                                        @if(isset($project_employee->employee_id))
                                                                                            <a href="{{ route('employee.show',$project_employee->employee_id) }}"
                                                                                               title="View">
                                                                                                <button
                                                                                                    type="button"
                                                                                                    class="btn btn-success action-icon">
                                                                                                    <i class="fa fa-eye"></i>
                                                                                                </button>
                                                                                            </a>
                                                                                        @endif
                                                                                        {{--                                                                                    END SHOW EMPLOYEE--}}

                                                                                        {{--                                                                                    EDIT EMPLOYEE--}}
                                                                                        <a href="#myModal"
                                                                                           data-toggle="modal"
                                                                                           data-target="#myModal_{{ $project_employee->id}}"
                                                                                           data-id="{{$project_employee->id}}">
                                                                                            <button
                                                                                                type="button"
                                                                                                class="btn btn-info action-icon">
                                                                                                <i class="fa fa-edit"></i>
                                                                                            </button>
                                                                                        </a>
                                                                                        <div class="modal fade"
                                                                                             id="myModal_{{ $project_employee->id}}"
                                                                                             role="dialog">
                                                                                            <div
                                                                                                class="modal-dialog modal-lg">
                                                                                                <div
                                                                                                    class="modal-content form-group col-md-12">
                                                                                                    <div
                                                                                                        class="modal-header">
                                                                                                        @foreach($employees as $employee)
                                                                                                            @if($project_employee->employee_id == $employee->id)
                                                                                                                <h4 class="modal-title"
                                                                                                                    style="color:#000000">{{$employee->unique_id}}
                                                                                                                    . {{$employee->first_name}} {{$employee->last_name}}</h4>
                                                                                                            @endif
                                                                                                        @endforeach
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="modal-body">
                                                                                                        {{ Form::open(['class' => '', 'files' => true, 'url' => 'project/employee_edit/'.$project_employee->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}

                                                                                                        <div
                                                                                                                    class="form-group col-md-10">
                                                                                                                    <label
                                                                                                                        for="employee"><strong>
                                                                                                                            Amendment
                                                                                                                            No:</strong></label>
                                                                                                                    <select
                                                                                                                        class="js-example-basic-single col-sm-12 {{ $errors->has('amendment') ? ' is-invalid' : '' }}"
                                                                                                                        name="amendment"
                                                                                                                        id="amendment">
                                                                                                                        <option
                                                                                                                            value="">
                                                                                                                            Select
                                                                                                                            Amendment
                                                                                                                            No
                                                                                                                        </option>
                                                                                                                        @if(isset($maxAmendment))
                                                                                                                            @for($jy=1; $jy<=$maxAmendment; $jy++)
                                                                                                                                <option
                                                                                                                                    value="{{ $jy}}">{{$jy}}</option>
                                                                                                                            @endfor
                                                                                                                        @endif
                                                                                                                    </select>
                                                                                                                </div>

                                                                                                                <div
                                                                                                                    class="form-group col-md-10">
                                                                                                                    <label
                                                                                                                        for="employee"><strong>
                                                                                                                            Employee
                                                                                                                            Name:</strong></label>
                                                                                                                    <br>
                                                                                                                    <select
                                                                                                                        class="js-example-basic-single col-sm-12 {{ $errors->has('employee') ? ' is-invalid' : '' }}"
                                                                                                                        name="employee"
                                                                                                                        id="employee">
                                                                                                                        <option
                                                                                                                            value="">
                                                                                                                            Select
                                                                                                                            Employee
                                                                                                                        </option>
                                                                                                                        @if(isset($employees))
                                                                                                                            @foreach($employees as $employee)
                                                                                                                                <option
                                                                                                                                    value="{{ $employee->id }}" {{ $project_employee->employee_id == $employee->id ? 'selected' : ''  }}>{{$employee->unique_id}}
                                                                                                                                    . {{$employee->first_name}} {{$employee->last_name}}</option>
                                                                                                                            @endforeach
                                                                                                                        @endif
                                                                                                                    </select>
                                                                                                                </div>

                                                                                                                <div
                                                                                                                    class="form-group col-md-10">
                                                                                                                    <label
                                                                                                                        for="title"><strong>Title:</strong></label>
                                                                                                                    <input
                                                                                                                        type="text"
                                                                                                                        class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}"
                                                                                                                        value="{{ $project_employee->title }}"
                                                                                                                        name="title"
                                                                                                                        required/>
                                                                                                                </div>

                                                                                                                @if($distinct_phase->project_phase < 3 )
                                                                                                                    <div
                                                                                                                        class="form-group col-md-10">
                                                                                                                        <label
                                                                                                                            for="man_hour"><strong>Man
                                                                                                                                hour:</strong></label>
                                                                                                                        <input
                                                                                                                            type="number"
                                                                                                                            step="0.01"
                                                                                                                            class="form-control {{ $errors->has('man_hour') ? ' is-invalid' : '' }}"
                                                                                                                            value="{{ $project_employee->man_hour }}"
                                                                                                                            name="man_hour"
                                                                                                                            required/>
                                                                                                                    </div>
                                                                                                                @else
                                                                                                                    <div
                                                                                                                        class="form-group col-md-10">
                                                                                                                        <label
                                                                                                                            for="staff_month_rate"><strong>Staff
                                                                                                                                Month
                                                                                                                                Rate:</strong></label>
                                                                                                                        <input
                                                                                                                            type="number"
                                                                                                                            step="0.01"
                                                                                                                            class="form-control {{ $errors->has('staff_month_rate') ? ' is-invalid' : '' }}"
                                                                                                                            value="{{ $project_employee->staff_month_rate }}"
                                                                                                                            name="staff_month_rate"
                                                                                                                            required/>
                                                                                                                    </div>

                                                                                                                    <div
                                                                                                                        class="form-group col-md-10">
                                                                                                                        <label
                                                                                                                            for="staff_month_proposal"><strong>Staff
                                                                                                                                month(Proposal):</strong></label>
                                                                                                                        <input
                                                                                                                            type="number"
                                                                                                                            step="0.01"
                                                                                                                            class="form-control {{ $errors->has('staff_month_proposal') ? ' is-invalid' : '' }}"
                                                                                                                            value="{{ $project_employee->staff_month_proposal }}"
                                                                                                                            name="staff_month_proposal"
                                                                                                                            required/>
                                                                                                                    </div>

                                                                                                                    <div
                                                                                                                        class="form-group col-md-10">
                                                                                                                        <label
                                                                                                                            for="staff_month_agreed"><strong>Staff
                                                                                                                                month(Agreed):</strong></label>
                                                                                                                        <input
                                                                                                                            type="number"
                                                                                                                            step="0.01"
                                                                                                                            class="form-control {{ $errors->has('staff_month_agreed') ? ' is-invalid' : '' }}"
                                                                                                                            value="{{ $project_employee->staff_month_agreed }}"
                                                                                                                            name="staff_month_agreed"
                                                                                                                            required/>
                                                                                                                    </div>
                                                                                                                @endif

                                                                                                                <div
                                                                                                                    class="form-group col-md-2">
                                                                                                                    <label
                                                                                                                        for="submit"></label>
                                                                                                                    <input
                                                                                                                        type="submit"
                                                                                                                        class="form-control btn btn-primary m-b-0"
                                                                                                                        style="margin-top: 5px;"/>
                                                                                                                </div>
                                                                                                                {{ Form::close()}}
                                                                                                            </div>
                                                                                                            <div
                                                                                                                class="modal-footer">
                                                                                                                <button
                                                                                                                    type="button"
                                                                                                                    class="btn btn-danger"
                                                                                                                    data-dismiss="modal">
                                                                                                                    Close
                                                                                                                </button>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                {{--                                                                                    END EDIT EMPLOYEE--}}

                                                                                                {{--                                                                                    ASSIGN EMPLOYEE--}}
                                                                                                @if(isset($project_employee->employee_id))
                                                                                                    {{--                                                                                        @if(isset($project_employee->employee_id) && isset($editData->project_status) && $editData->project_status == 'completed')--}}
                                                                                                    <a href="#assignEmp"
                                                                                                       data-toggle="modal"
                                                                                                       data-target="#assignEmp_{{ $project_employee->id}}"
                                                                                                       data-id="{{$project_employee->id}}">
                                                                                                        <button
                                                                                                            type="button"
                                                                                                            class="btn btn-success action-icon">
                                                                                                            Assign
                                                                                                        </button>
                                                                                                    </a>
                                                                                                    <div
                                                                                                        class="modal fade"
                                                                                                        id="assignEmp_{{$project_employee->id}}"
                                                                                                        role="dialog">
                                                                                                        <div
                                                                                                            class="modal-dialog modal-lg">
                                                                                                            <div
                                                                                                                class="modal-content form-group col-md-12">
                                                                                                                <div
                                                                                                                    class="modal-header">
                                                                                                                    <h4 class="modal-title"
                                                                                                                        style="color:#000000">
                                                                                                                        @if(isset($project_employee->employee_id))
                                                                                                                            {{ $project_employee->employee->first_name }} {{ $project_employee->employee->last_name }}
                                                                                                                        @endif
                                                                                                                    </h4>
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="modal-body">
                                                                                                                    {{ Form::open(['class' => '', 'files' => true, 'url' => 'project/employee_reassign/'.$project_employee->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                                                                                                    <div
                                                                                                                        class="form-group col-md-11">
                                                                                                                        <label
                                                                                                                            for="reassign">
                                                                                                                            Reassign
                                                                                                                            To</label><br>
                                                                                                                        <select
                                                                                                                            class="js-example-basic-single  {{ $errors->has('reassign') ? ' is-invalid' : '' }}"
                                                                                                                            name="reassign"
                                                                                                                            id="reassign">
                                                                                                                            <option
                                                                                                                                value="0" {{ old('reassign')== 0 ? 'selected' : ''  }}>
                                                                                                                                Head
                                                                                                                                Office
                                                                                                                            </option>
                                                                                                                            @foreach($all_projects as $project)
                                                                                                                                <option
                                                                                                                                    value="{{ $project->id }}" {{ old('reassign')== $project->id ? 'selected' : ''  }}>{{ $project->project_name }} </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                        @if ($errors->has('reassign'))
                                                                                                                            <span
                                                                                                                                class="invalid-feedback"
                                                                                                                                role="alert">
                                                                                                                        <span
                                                                                                                            class="messages"><strong>{{ $errors->first('reassign') }}</strong></span>
                                                                                                                    </span>
                                                                                                                        @endif
                                                                                                                    </div>
                                                                                                                    <div
                                                                                                                        class="form-group col-md-6">
                                                                                                                        <label
                                                                                                                            for="submit"></label>
                                                                                                                        <input
                                                                                                                            type="submit"
                                                                                                                            class="form-control btn btn-primary m-b-0"
                                                                                                                            style="margin-top: 2em; margin-bottom: 2em"/>
                                                                                                                    </div>
                                                                                                                    {{ Form::close()}}
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                @endif
                                                                                                {{--                                                                                    END ASSIGN EMPLOYEE--}}

                                                                                                @hasrole('Super Admin')
                                                                                                <a class="modalLink"
                                                                                                   title="Delete"
                                                                                                   data-modal-size="modal-md"
                                                                                                   href="{{url('deleteProjectEmployeeView', $project_employee->id)}}">
                                                                                                    <button
                                                                                                        type="button"
                                                                                                        class="btn btn-danger action-icon">
                                                                                                        <i class="fa fa-trash-o"></i>
                                                                                                    </button>
                                                                                                </a>
                                                                                                @endhasrole
                                                                                            </td>
                                                                                        @endif
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                        <tr>
                                                                            <td></td>
                                                                            <th colspan="3">Total</th>
                                                                            @if($distinct_phase->project_phase < 3)
                                                                                <th>{{ $total_hour }}</th>
                                                                                <td></td>
                                                                                <th> {{ number_format($total_amount,2,".",",") }}</th>
                                                                            @else
                                                                                <td></td>
                                                                                <td></td>
                                                                                <th>{{ $total_hour }}</th>
                                                                                <th> {{ number_format($total_amount,2,".",",") }}</th>
                                                                            @endif
                                                                            <td></td>
                                                                            <td></td>
                                                                        </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>

                                        @endforeach
                                    @endif

                                    {{--                                    @if($maxAmendment>0)--}}
                                    {{--                                        <div class="card-block">--}}
                                    {{--                                            @if(isset($distinct_employee_phase))--}}
                                    {{--                                                @foreach( $distinct_employee_phase as $distinct_phase)--}}

                                    {{--                                                    <div class="card">--}}
                                    {{--                                                        <div class="card-header">--}}
                                    {{--                                                            <strong>--}}
                                    {{--                                                                @foreach($phases as $phase)--}}
                                    {{--                                                                    @if( $distinct_phase->project_phase == $phase->defined_id )--}}
                                    {{--                                                                        PHASE ---}}
                                    {{--                                                                        00{{$phase->defined_id}} {{$phase->name}}--}}
                                    {{--                                                                    @endif--}}
                                    {{--                                                                @endforeach--}}
                                    {{--                                                            </strong>--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                        <div class="card-header">--}}

                                    {{--                                                            <strong style="color: #00aeef">--}}
                                    {{--                                                                Contract & Amendment--}}
                                    {{--                                                            </strong>--}}

                                    {{--                                                        </div>--}}
                                    {{--                                                        <div class="card-block">--}}
                                    {{--                                                            <div class="table-responsive">--}}
                                    {{--                                                                <table id="project_employee"--}}
                                    {{--                                                                       class="table table-striped table-bordered">--}}
                                    {{--                                                                    <thead>--}}
                                    {{--                                                                    <tr>--}}
                                    {{--                                                                        <th>SL.</th>--}}
                                    {{--                                                                        <th>Employee ID</th>--}}
                                    {{--                                                                        <th>Employee Name</th>--}}
                                    {{--                                                                        <th>Position</th>--}}
                                    {{--                                                                        @if($distinct_phase->project_phase < 3 )--}}
                                    {{--                                                                            <th>Man Hour</th>--}}
                                    {{--                                                                            <th>Hourly Rate</th>--}}
                                    {{--                                                                        @else--}}
                                    {{--                                                                            <th>Staff Month <br> Rate</th>--}}
                                    {{--                                                                            <th>Staff Month <br> (Proposed)</th>--}}
                                    {{--                                                                            <th>Staff Month <br> (Agreed)</th>--}}
                                    {{--                                                                        @endif--}}
                                    {{--                                                                        <th>Total Amount</th>--}}
                                    {{--                                                                        <th>Added By</th>--}}
                                    {{--                                                                        <th>Action</th>--}}
                                    {{--                                                                    </tr>--}}
                                    {{--                                                                    </thead>--}}
                                    {{--                                                                    <tbody>--}}
                                    {{--                                                                    @php $i = 1; $total_hour = 0; $total_input = 0; $total_amount = 0; @endphp--}}
                                    {{--                                                                    <!-- SHOW ALL EMPLOYEES OF THIS PROJECT -->--}}
                                    {{--                                                                    @if(isset($project_employees))--}}
                                    {{--                                                                        @foreach($project_employees as $project_employee)--}}
                                    {{--                                                                            @if($project_employee->project_phase == $distinct_phase->project_phase)--}}
                                    {{--                                                                                <tr>--}}
                                    {{--                                                                                    <td> {{$i++}} </td>--}}
                                    {{--                                                                                    <td>--}}
                                    {{--                                                                                        @if(isset($project_employee->employee_id))--}}
                                    {{--                                                                                            {{ $project_employee->employee->unique_id }}--}}
                                    {{--                                                                                        @endif--}}
                                    {{--                                                                                    </td>--}}
                                    {{--                                                                                    <td>--}}
                                    {{--                                                                                        @if(isset($project_employee->employee_id))--}}
                                    {{--                                                                                            {{ $project_employee->employee->first_name }} {{ $project_employee->employee->last_name }}--}}
                                    {{--                                                                                        @endif--}}
                                    {{--                                                                                    </td>--}}
                                    {{--                                                                                    <td> {{ $project_employee->title }}</td>--}}
                                    {{--                                                                                    @if($distinct_phase->project_phase < 3 )--}}
                                    {{--                                                                                        <td> {{ $project_employee->man_hour }}</td>--}}
                                    {{--                                                                                        @php $total_hour += $project_employee->man_hour; @endphp--}}
                                    {{--                                                                                        <td>--}}
                                    {{--                                                                                            @foreach( $salaries as $salary )--}}
                                    {{--                                                                                                @if( $project_employee->employee_id == $salary->employee_id)--}}
                                    {{--                                                                                                    {{ $salary->hourly_rate }}--}}
                                    {{--                                                                                                    @php $rate = $salary->hourly_rate @endphp--}}
                                    {{--                                                                                                @endif--}}
                                    {{--                                                                                            @endforeach--}}
                                    {{--                                                                                        </td>--}}
                                    {{--                                                                                        <td>--}}
                                    {{--                                                                                            @php $total_rate = $project_employee->man_hour*$rate; $total_amount += $total_rate; @endphp--}}
                                    {{--                                                                                            {{ $total_rate }}--}}
                                    {{--                                                                                        </td>--}}
                                    {{--                                                                                    @else--}}
                                    {{--                                                                                        <td> {{ $project_employee->staff_month_rate	 }}</td>--}}
                                    {{--                                                                                        <td> {{ $project_employee->staff_month_proposal }}</td>--}}
                                    {{--                                                                                        <td> {{ $project_employee->staff_month_agreed }}</td>--}}
                                    {{--                                                                                        @php $total_hour += $project_employee->staff_month_agreed; @endphp--}}
                                    {{--                                                                                        @php $total_rate = $project_employee->staff_month_rate*$project_employee->staff_month_agreed; @endphp--}}
                                    {{--                                                                                        @php $total_amount += $total_rate; @endphp--}}
                                    {{--                                                                                        <td> {{ $total_rate }}</td>--}}
                                    {{--                                                                                    @endif--}}
                                    {{--                                                                                    <td>--}}
                                    {{--                                                                                        @foreach( $users as $user )--}}
                                    {{--                                                                                            @if( $project_employee->created_by == $user->id)--}}
                                    {{--                                                                                                {{ $user->name }}--}}
                                    {{--                                                                                            @endif--}}
                                    {{--                                                                                        @endforeach--}}
                                    {{--                                                                                    </td>--}}
                                    {{--                                                                                    @if(isset($project_employee->reassign))--}}
                                    {{--                                                                                        <td style="color: #711c1c;">--}}
                                    {{--                                                                                            Reassigned to <br>--}}
                                    {{--                                                                                            @if($project_employee->reassign == 0)--}}
                                    {{--                                                                                                Head Office--}}
                                    {{--                                                                                            @else {{ $project_employee->ressign_project->project_name }}--}}
                                    {{--                                                                                            @endif--}}
                                    {{--                                                                                        </td>--}}
                                    {{--                                                                                    @else--}}
                                    {{--                                                                                        <td>--}}
                                    {{--                                                                                            --}}{{--                                                                                    SHOW EMPLOYEE--}}
                                    {{--                                                                                            @if(isset($project_employee->employee_id))--}}
                                    {{--                                                                                                <a href="{{ route('employee.show',$project_employee->employee_id) }}"--}}
                                    {{--                                                                                                   title="View">--}}
                                    {{--                                                                                                    <button--}}
                                    {{--                                                                                                        type="button"--}}
                                    {{--                                                                                                        class="btn btn-success action-icon">--}}
                                    {{--                                                                                                        <i class="fa fa-eye"></i>--}}
                                    {{--                                                                                                    </button>--}}
                                    {{--                                                                                                </a>--}}
                                    {{--                                                                                            @endif--}}
                                    {{--                                                                                            --}}{{--                                                                                    END SHOW EMPLOYEE--}}

                                    {{--                                                                                            --}}{{--                                                                                    EDIT EMPLOYEE--}}
                                    {{--                                                                                            <a href="#myModal"--}}
                                    {{--                                                                                               data-toggle="modal"--}}
                                    {{--                                                                                               data-target="#myModal_{{ $project_employee->id}}"--}}
                                    {{--                                                                                               data-id="{{$project_employee->id}}">--}}
                                    {{--                                                                                                <button type="button"--}}
                                    {{--                                                                                                        class="btn btn-info action-icon">--}}
                                    {{--                                                                                                    <i class="fa fa-edit"></i>--}}
                                    {{--                                                                                                </button>--}}
                                    {{--                                                                                            </a>--}}
                                    {{--                                                                                            <div class="modal fade"--}}
                                    {{--                                                                                                 id="myModal_{{ $project_employee->id}}"--}}
                                    {{--                                                                                                 role="dialog">--}}
                                    {{--                                                                                                <div--}}
                                    {{--                                                                                                    class="modal-dialog modal-lg">--}}
                                    {{--                                                                                                    <div--}}
                                    {{--                                                                                                        class="modal-content form-group col-md-12">--}}
                                    {{--                                                                                                        <div--}}
                                    {{--                                                                                                            class="modal-header">--}}
                                    {{--                                                                                                            @foreach($employees as $employee)--}}
                                    {{--                                                                                                                @if($project_employee->employee_id == $employee->id)--}}
                                    {{--                                                                                                                    <h4 class="modal-title"--}}
                                    {{--                                                                                                                        style="color:#000000">{{$employee->unique_id}}--}}
                                    {{--                                                                                                                        . {{$employee->first_name}} {{$employee->last_name}}</h4>--}}
                                    {{--                                                                                                                @endif--}}
                                    {{--                                                                                                            @endforeach--}}
                                    {{--                                                                                                        </div>--}}
                                    {{--                                                                                                        <div--}}
                                    {{--                                                                                                            class="modal-body">--}}
                                    {{--                                                                                                            {{ Form::open(['class' => '', 'files' => true, 'url' => 'project/employee_edit/'.$project_employee->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}--}}
                                    {{--                                                                                                            <div--}}
                                    {{--                                                                                                                class="form-group col-md-10">--}}
                                    {{--                                                                                                                <label--}}
                                    {{--                                                                                                                    for="employee"><strong>--}}
                                    {{--                                                                                                                        Employee--}}
                                    {{--                                                                                                                        Name:</strong></label>--}}
                                    {{--                                                                                                                <br>--}}
                                    {{--                                                                                                                <select--}}
                                    {{--                                                                                                                    class="js-example-basic-single col-sm-12 {{ $errors->has('employee') ? ' is-invalid' : '' }}"--}}
                                    {{--                                                                                                                    name="employee"--}}
                                    {{--                                                                                                                    id="employee">--}}
                                    {{--                                                                                                                    <option--}}
                                    {{--                                                                                                                        value="">--}}
                                    {{--                                                                                                                        Select--}}
                                    {{--                                                                                                                        Employee--}}
                                    {{--                                                                                                                    </option>--}}
                                    {{--                                                                                                                    @if(isset($employees))--}}
                                    {{--                                                                                                                        @foreach($employees as $employee)--}}
                                    {{--                                                                                                                            <option--}}
                                    {{--                                                                                                                                value="{{ $employee->id }}" {{ $project_employee->employee_id == $employee->id ? 'selected' : ''  }}>{{$employee->unique_id}}--}}
                                    {{--                                                                                                                                . {{$employee->first_name}} {{$employee->last_name}}</option>--}}
                                    {{--                                                                                                                        @endforeach--}}
                                    {{--                                                                                                                    @endif--}}
                                    {{--                                                                                                                </select>--}}
                                    {{--                                                                                                            </div>--}}

                                    {{--                                                                                                            <div--}}
                                    {{--                                                                                                                class="form-group col-md-10">--}}
                                    {{--                                                                                                                <label--}}
                                    {{--                                                                                                                    for="title"><strong>Title:</strong></label>--}}
                                    {{--                                                                                                                <input--}}
                                    {{--                                                                                                                    type="text"--}}
                                    {{--                                                                                                                    class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}"--}}
                                    {{--                                                                                                                    value="{{ $project_employee->title }}"--}}
                                    {{--                                                                                                                    name="title"--}}
                                    {{--                                                                                                                    required/>--}}
                                    {{--                                                                                                            </div>--}}

                                    {{--                                                                                                            @if($distinct_phase->project_phase < 3 )--}}
                                    {{--                                                                                                                <div--}}
                                    {{--                                                                                                                    class="form-group col-md-10">--}}
                                    {{--                                                                                                                    <label--}}
                                    {{--                                                                                                                        for="man_hour"><strong>Man--}}
                                    {{--                                                                                                                            hour:</strong></label>--}}
                                    {{--                                                                                                                    <input--}}
                                    {{--                                                                                                                        type="number"--}}
                                    {{--                                                                                                                        step="0.01"--}}
                                    {{--                                                                                                                        class="form-control {{ $errors->has('man_hour') ? ' is-invalid' : '' }}"--}}
                                    {{--                                                                                                                        value="{{ $project_employee->man_hour }}"--}}
                                    {{--                                                                                                                        name="man_hour"--}}
                                    {{--                                                                                                                        required/>--}}
                                    {{--                                                                                                                </div>--}}
                                    {{--                                                                                                            @else--}}
                                    {{--                                                                                                                <div--}}
                                    {{--                                                                                                                    class="form-group col-md-10">--}}
                                    {{--                                                                                                                    <label--}}
                                    {{--                                                                                                                        for="staff_month_rate"><strong>Staff--}}
                                    {{--                                                                                                                            Month--}}
                                    {{--                                                                                                                            Rate:</strong></label>--}}
                                    {{--                                                                                                                    <input--}}
                                    {{--                                                                                                                        type="number"--}}
                                    {{--                                                                                                                        step="0.01"--}}
                                    {{--                                                                                                                        class="form-control {{ $errors->has('staff_month_rate') ? ' is-invalid' : '' }}"--}}
                                    {{--                                                                                                                        value="{{ $project_employee->staff_month_rate }}"--}}
                                    {{--                                                                                                                        name="staff_month_rate"--}}
                                    {{--                                                                                                                        required/>--}}
                                    {{--                                                                                                                </div>--}}

                                    {{--                                                                                                                <div--}}
                                    {{--                                                                                                                    class="form-group col-md-10">--}}
                                    {{--                                                                                                                    <label--}}
                                    {{--                                                                                                                        for="staff_month_proposal"><strong>Staff--}}
                                    {{--                                                                                                                            month(Proposal):</strong></label>--}}
                                    {{--                                                                                                                    <input--}}
                                    {{--                                                                                                                        type="number"--}}
                                    {{--                                                                                                                        step="0.01"--}}
                                    {{--                                                                                                                        class="form-control {{ $errors->has('staff_month_proposal') ? ' is-invalid' : '' }}"--}}
                                    {{--                                                                                                                        value="{{ $project_employee->staff_month_proposal }}"--}}
                                    {{--                                                                                                                        name="staff_month_proposal"--}}
                                    {{--                                                                                                                        required/>--}}
                                    {{--                                                                                                                </div>--}}

                                    {{--                                                                                                                <div--}}
                                    {{--                                                                                                                    class="form-group col-md-10">--}}
                                    {{--                                                                                                                    <label--}}
                                    {{--                                                                                                                        for="staff_month_agreed"><strong>Staff--}}
                                    {{--                                                                                                                            month(Agreed):</strong></label>--}}
                                    {{--                                                                                                                    <input--}}
                                    {{--                                                                                                                        type="number"--}}
                                    {{--                                                                                                                        step="0.01"--}}
                                    {{--                                                                                                                        class="form-control {{ $errors->has('staff_month_agreed') ? ' is-invalid' : '' }}"--}}
                                    {{--                                                                                                                        value="{{ $project_employee->staff_month_agreed }}"--}}
                                    {{--                                                                                                                        name="staff_month_agreed"--}}
                                    {{--                                                                                                                        required/>--}}
                                    {{--                                                                                                                </div>--}}
                                    {{--                                                                                                            @endif--}}

                                    {{--                                                                                                            <div--}}
                                    {{--                                                                                                                class="form-group col-md-2">--}}
                                    {{--                                                                                                                <label--}}
                                    {{--                                                                                                                    for="submit"></label>--}}
                                    {{--                                                                                                                <input--}}
                                    {{--                                                                                                                    type="submit"--}}
                                    {{--                                                                                                                    class="form-control btn btn-primary m-b-0"--}}
                                    {{--                                                                                                                    style="margin-top: 5px;"/>--}}
                                    {{--                                                                                                            </div>--}}
                                    {{--                                                                                                            {{ Form::close()}}--}}
                                    {{--                                                                                                        </div>--}}
                                    {{--                                                                                                        <div--}}
                                    {{--                                                                                                            class="modal-footer">--}}
                                    {{--                                                                                                            <button--}}
                                    {{--                                                                                                                type="button"--}}
                                    {{--                                                                                                                class="btn btn-danger"--}}
                                    {{--                                                                                                                data-dismiss="modal">--}}
                                    {{--                                                                                                                Close--}}
                                    {{--                                                                                                            </button>--}}
                                    {{--                                                                                                        </div>--}}
                                    {{--                                                                                                    </div>--}}
                                    {{--                                                                                                </div>--}}
                                    {{--                                                                                            </div>--}}
                                    {{--                                                                                            --}}{{--                                                                                    END EDIT EMPLOYEE--}}

                                    {{--                                                                                            --}}{{--                                                                                    ASSIGN EMPLOYEE--}}
                                    {{--                                                                                            @if(isset($project_employee->employee_id))--}}
                                    {{--                                                                                                --}}{{--                                                                                        @if(isset($project_employee->employee_id) && isset($editData->project_status) && $editData->project_status == 'completed')--}}
                                    {{--                                                                                                <a href="#assignEmp"--}}
                                    {{--                                                                                                   data-toggle="modal"--}}
                                    {{--                                                                                                   data-target="#assignEmp_{{ $project_employee->id}}"--}}
                                    {{--                                                                                                   data-id="{{$project_employee->id}}">--}}
                                    {{--                                                                                                    <button--}}
                                    {{--                                                                                                        type="button"--}}
                                    {{--                                                                                                        class="btn btn-success action-icon">--}}
                                    {{--                                                                                                        Assign--}}
                                    {{--                                                                                                    </button>--}}
                                    {{--                                                                                                </a>--}}
                                    {{--                                                                                                <div class="modal fade"--}}
                                    {{--                                                                                                     id="assignEmp_{{$project_employee->id}}"--}}
                                    {{--                                                                                                     role="dialog">--}}
                                    {{--                                                                                                    <div--}}
                                    {{--                                                                                                        class="modal-dialog modal-lg">--}}
                                    {{--                                                                                                        <div--}}
                                    {{--                                                                                                            class="modal-content form-group col-md-12">--}}
                                    {{--                                                                                                            <div--}}
                                    {{--                                                                                                                class="modal-header">--}}
                                    {{--                                                                                                                <h4 class="modal-title"--}}
                                    {{--                                                                                                                    style="color:#000000">--}}
                                    {{--                                                                                                                    @if(isset($project_employee->employee_id))--}}
                                    {{--                                                                                                                        {{ $project_employee->employee->first_name }} {{ $project_employee->employee->last_name }}--}}
                                    {{--                                                                                                                    @endif--}}
                                    {{--                                                                                                                </h4>--}}
                                    {{--                                                                                                            </div>--}}
                                    {{--                                                                                                            <div--}}
                                    {{--                                                                                                                class="modal-body">--}}
                                    {{--                                                                                                                {{ Form::open(['class' => '', 'files' => true, 'url' => 'project/employee_reassign/'.$project_employee->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}--}}
                                    {{--                                                                                                                <div--}}
                                    {{--                                                                                                                    class="form-group col-md-11">--}}
                                    {{--                                                                                                                    <label--}}
                                    {{--                                                                                                                        for="reassign">--}}
                                    {{--                                                                                                                        Reassign--}}
                                    {{--                                                                                                                        To</label><br>--}}
                                    {{--                                                                                                                    <select--}}
                                    {{--                                                                                                                        class="js-example-basic-single  {{ $errors->has('reassign') ? ' is-invalid' : '' }}"--}}
                                    {{--                                                                                                                        name="reassign"--}}
                                    {{--                                                                                                                        id="reassign">--}}
                                    {{--                                                                                                                        <option--}}
                                    {{--                                                                                                                            value="0" {{ old('reassign')== 0 ? 'selected' : ''  }}>--}}
                                    {{--                                                                                                                            Head--}}
                                    {{--                                                                                                                            Office--}}
                                    {{--                                                                                                                        </option>--}}
                                    {{--                                                                                                                        @foreach($all_projects as $project)--}}
                                    {{--                                                                                                                            <option--}}
                                    {{--                                                                                                                                value="{{ $project->id }}" {{ old('reassign')== $project->id ? 'selected' : ''  }}>{{ $project->project_name }} </option>--}}
                                    {{--                                                                                                                        @endforeach--}}
                                    {{--                                                                                                                    </select>--}}
                                    {{--                                                                                                                    @if ($errors->has('reassign'))--}}
                                    {{--                                                                                                                        <span--}}
                                    {{--                                                                                                                            class="invalid-feedback"--}}
                                    {{--                                                                                                                            role="alert">--}}
                                    {{--                                                                                                                        <span--}}
                                    {{--                                                                                                                            class="messages"><strong>{{ $errors->first('reassign') }}</strong></span>--}}
                                    {{--                                                                                                                    </span>--}}
                                    {{--                                                                                                                    @endif--}}
                                    {{--                                                                                                                </div>--}}
                                    {{--                                                                                                                <div--}}
                                    {{--                                                                                                                    class="form-group col-md-6">--}}
                                    {{--                                                                                                                    <label--}}
                                    {{--                                                                                                                        for="submit"></label>--}}
                                    {{--                                                                                                                    <input--}}
                                    {{--                                                                                                                        type="submit"--}}
                                    {{--                                                                                                                        class="form-control btn btn-primary m-b-0"--}}
                                    {{--                                                                                                                        style="margin-top: 2em; margin-bottom: 2em"/>--}}
                                    {{--                                                                                                                </div>--}}
                                    {{--                                                                                                                {{ Form::close()}}--}}
                                    {{--                                                                                                            </div>--}}
                                    {{--                                                                                                        </div>--}}
                                    {{--                                                                                                    </div>--}}
                                    {{--                                                                                                </div>--}}
                                    {{--                                                                                            @endif--}}
                                    {{--                                                                                            --}}{{--                                                                                    END ASSIGN EMPLOYEE--}}

                                    {{--                                                                                            @hasrole('Super Admin')--}}
                                    {{--                                                                                            <a class="modalLink"--}}
                                    {{--                                                                                               title="Delete"--}}
                                    {{--                                                                                               data-modal-size="modal-md"--}}
                                    {{--                                                                                               href="{{url('deleteProjectEmployeeView', $project_employee->id)}}">--}}
                                    {{--                                                                                                <button type="button"--}}
                                    {{--                                                                                                        class="btn btn-danger action-icon">--}}
                                    {{--                                                                                                    <i class="fa fa-trash-o"></i>--}}
                                    {{--                                                                                                </button>--}}
                                    {{--                                                                                            </a>--}}
                                    {{--                                                                                            @endhasrole--}}
                                    {{--                                                                                        </td>--}}
                                    {{--                                                                                    @endif--}}
                                    {{--                                                                                </tr>--}}
                                    {{--                                                                            @endif--}}
                                    {{--                                                                        @endforeach--}}
                                    {{--                                                                    @endif--}}
                                    {{--                                                                    <tr>--}}
                                    {{--                                                                        <td></td>--}}
                                    {{--                                                                        <th colspan="3">Total</th>--}}
                                    {{--                                                                        @if($distinct_phase->project_phase < 3)--}}
                                    {{--                                                                            <th>{{ $total_hour }}</th>--}}
                                    {{--                                                                            <td></td>--}}
                                    {{--                                                                            <th> {{ number_format($total_amount,2,".",",") }}</th>--}}
                                    {{--                                                                        @else--}}
                                    {{--                                                                            <td></td>--}}
                                    {{--                                                                            <td></td>--}}
                                    {{--                                                                            <th>{{ $total_hour }}</th>--}}
                                    {{--                                                                            <th> {{ number_format($total_amount,2,".",",") }}</th>--}}
                                    {{--                                                                        @endif--}}
                                    {{--                                                                        <td></td>--}}
                                    {{--                                                                        <td></td>--}}
                                    {{--                                                                    </tr>--}}
                                    {{--                                                                    </tbody>--}}
                                    {{--                                                                </table>--}}
                                    {{--                                                            </div>--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                    </div>--}}

                                    {{--                                                @endforeach--}}
                                    {{--                                            @endif--}}
                                    {{--                                        </div>--}}
                                    {{--                                    @endif--}}

                                    <div class="text-bottom text-center pt-5 mt-5 footer" style="display: none"
                                         id="footer">
                                        <div class="row">
                                            <div class="col">
                                                <p style="font-size: 0.9rem; background-color: #ece7e4; color: black">
                                                    ERP Version 1.1 | Developed by: White Paper | Printed
                                                    By: {{ Auth::user()->name }} | <span id="datetime1"></p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{--// BUDGET TAB STARTS--}}
                    @if($editData->project_phase >= 3)
                        <div class="tab-pane" id="budget" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    @if( isset($editData->project_name) )
                                        <h5 class="card-header-text"
                                            style="font-size: 1rem;">{{ $editData->project_name }}</h5>
                                    @else
                                        <h5 class="card-header-text">No Project Name</h5>
                                    @endif
                                    <button class="btn btn-success printBtn"
                                            onclick="printExpensesDiv('project_expenses')"
                                            style="float: right; padding: 10px;" target="_blank">Print Expenses List
                                    </button>
                                    <a href="{{ url('project/reimbursable/amendment/create',$editData->id) }}"
                                       style="float: right; padding: 10px; color: white;margin-right: 10px"
                                       class="btn btn-success"> Add Amendment </a>

                                </div>
                                <div class="card-block">
                                    <div class="card">
                                        <div class="card-block">
                                            {{ Form::open(['class' => '', 'files' => true, 'url' => 'project/budget/'.$editData->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                            {{csrf_field()}}

                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <label for="employee"><strong> Amendment No:</strong></label>
                                                    <select
                                                        class="js-example-basic-single col-sm-12 {{ $errors->has('amendment') ? ' is-invalid' : '' }}"
                                                        name="amendment" id="amendment">
                                                        <option value="">Select Amendment No</option>
                                                        @if(isset($maxAmendmentBudget))
                                                            @for($ly=1; $ly<=$maxAmendmentBudget; $ly++)
                                                                <option
                                                                    value="{{ $ly}}">{{$ly}}</option>
                                                            @endfor
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <div class="form-group col-md-3">
                                                        <label for="expense_name"><strong><span
                                                                    class="important">*</span> Expense
                                                                Name:</strong></label>
                                                        <input type=""
                                                               class="form-control {{ $errors->has('expense_name') ? ' is-invalid' : '' }}"
                                                               value="{{ old('expense_name') }}" name="expense_name"
                                                               required/>
                                                        <p style="color: darkred">Maximum 150 characters</p>
                                                        @if ($errors->has('expense_name'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <span
                                                                    class="messages"><strong>{{ $errors->first('expense_name') }}</strong></span>
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <label for="unit"><strong> Unit:</strong></label>
                                                        <input type=""
                                                               class="form-control {{ $errors->has('unit') ? ' is-invalid' : '' }}"
                                                               value="{{ old('unit') }}" name="unit"/>
                                                        @if ($errors->has('unit'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <span
                                                                    class="messages"><strong>{{ $errors->first('unit') }}</strong></span>
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <label for="unit_cost"><strong><span class="important">*</span>
                                                                Unit Cost (BDT):</strong></label>
                                                        <input type="number" step="0.01"
                                                               class="form-control {{ $errors->has('unit_cost') ? ' is-invalid' : '' }}"
                                                               value="{{ old('unit_cost') }}" name="unit_cost"
                                                               required/>
                                                        @if ($errors->has('unit_cost'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <span
                                                                    class="messages"><strong>{{ $errors->first('unit_cost') }}</strong></span>
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <label for="quantity"><strong><span class="important">*</span>
                                                                Quantity:</strong></label>
                                                        <input type="number"
                                                               step="0.01"
                                                               class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}"
                                                               value="{{ old('quantity') }}" name="quantity" required/>
                                                        @if ($errors->has('quantity'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <span
                                                                    class="messages"><strong>{{ $errors->first('quantity') }}</strong></span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="collapse row col-md-12" id="add_exp">
                                                    @for($i=1; $i<=4; $i++)
                                                        <div class="form-group row col-md-12">
                                                            <div class="form-group col-md-3">
                                                                <label for="expense_name"><strong><span
                                                                            class="important">*</span> Expense
                                                                        Name:</strong></label>
                                                                <input type="" class="form-control {{ $errors->has('expense_name') ? ' is-invalid' : '' }}" value="{{ old('expense_name') }}" name="expense_name_{{$i}}"/>
                                                                <p style="color: darkred">Maximum 150 characters</p>
                                                                @if ($errors->has('expense_name'))
                                                                    <span class="invalid-feedback" role="alert">
                                                                <span class="messages"><strong>{{ $errors->first('expense_name') }}</strong></span>
                                                            </span>
                                                                @endif
                                                            </div>

                                                            <div class="form-group col-md-3">
                                                                <label for="unit"><strong> Unit:</strong></label>
                                                                <input type="" class="form-control {{ $errors->has('unit') ? ' is-invalid' : '' }}" value="{{ old('unit') }}" name="unit_{{$i}}"/>
                                                                @if ($errors->has('unit'))
                                                                    <span class="invalid-feedback" role="alert">
                                                                <span class="messages"><strong>{{ $errors->first('unit') }}</strong></span>
                                                            </span>
                                                                @endif
                                                            </div>

                                                            <div class="form-group col-md-3">
                                                                <label for="unit_cost"><strong><span class="important">*</span> Unit Cost (BDT):</strong></label>
                                                                <input type="number" step="0.01"
                                                                       class="form-control {{ $errors->has('unit_cost') ? ' is-invalid' : '' }}"
                                                                       value="{{ old('unit_cost') }}"
                                                                       name="unit_cost_{{$i}}"/>
                                                                @if ($errors->has('unit_cost'))
                                                                    <span class="invalid-feedback" role="alert">
                                                                <span
                                                                    class="messages"><strong>{{ $errors->first('unit_cost') }}</strong></span>
                                                            </span>
                                                                @endif
                                                            </div>

                                                            <div class="form-group col-md-3">
                                                                <label for="quantity"><strong><span
                                                                            class="important">*</span>
                                                                        Quantity:</strong></label>
                                                                <input type="number" step="0.01"
                                                                       class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}"
                                                                       value="{{ old('quantity') }}"
                                                                       name="quantity_{{$i}}"/>
                                                                @if ($errors->has('quantity'))
                                                                    <span class="invalid-feedback" role="alert">
                                                                <span
                                                                    class="messages"><strong>{{ $errors->first('quantity') }}</strong></span>
                                                            </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endfor
                                                </div>

                                                <div class="form-group row col-md-12">
                                                    <div class="form-group col-md-2">
                                                        <label for="add"></label>
                                                        <a href="#add_exp" class="form-control btn btn-primary m-b-0 collapsible" data-toggle="collapse" style="margin-top: 5px; color: white;">Add Row</a>
                                                    </div>

                                                    <div class="form-group col-md-2">
                                                        <label for="submit"></label>
                                                        <input type="submit" class="form-control btn btn-primary m-b-0"
                                                               style="margin-top: 5px;"/>
                                                    </div>
                                                </div>
                                            </div>
                                            {{ Form::close()}}
                                        </div>
                                    </div>
                                    <div class="card" id="project_expenses">
                                        <div class="logo row" id="logo" style="display:none;">
                                            <div class="col-md-4"
                                                 style="padding-left:5%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
                                                <img class="img-fluid"
                                                     src="{{asset('public/assets/images/epc_logo.png')}}" height="10"
                                                     width="120">
                                            </div>
                                            <div class="col-md-4"
                                                 style="padding-left:5%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
                                                <p style="margin-top: 25px; font-size: 22px; font-weight: bold;">{{ $editData->project_name }}
                                                    Project Expenses List</p>
                                            </div>
                                        </div>
                                        @if(isset($distinct_budget_phase))
                                            @foreach( $distinct_budget_phase as $distinct_phase)
                                                <div class="card-block">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <strong>
                                                                @foreach($phases as $phase)
                                                                    @if( $distinct_phase->project_phase == $phase->defined_id )
                                                                        PHASE -
                                                                        00{{$phase->defined_id}} {{$phase->name}}
                                                                    @endif
                                                                @endforeach
                                                            </strong>
                                                        </div>
                                                        @if($distinct_phase->amendment != 0)
                                                            <div class="card-header">

                                                                <strong style="color: #00aeef">
                                                                    Amendment No: {{$distinct_phase->amendment}}
                                                                </strong>

                                                            </div>
                                                        @endif
                                                        @if($distinct_phase->amendment==0)
                                                            <div class="card-header">

                                                                <strong style="color: #00aeef">
                                                                    Original Contract
                                                                </strong>

                                                            </div>
                                                        @endif
                                                        <div class="card-block">
                                                            @php $total_amount = 0; $total_credit = 0 @endphp
                                                            <div class="table-responsive">
                                                                <table id="budget_table"
                                                                       class="table table-striped table-bordered payment_table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Sl No.</th>
                                                                        <th>Expense Name</th>
                                                                        <th>Unit</th>
                                                                        <th>Unit Cost (BDT)</th>
                                                                        <th>Quantity</th>
                                                                        <th>Cost</th>
                                                                        <th>Recorded By</th>
                                                                        <th>Recorded On</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @if(isset($budgets))
                                                                        @php $i = 1;$checking1 = 0; @endphp
                                                                        @foreach($budgets as $budget)
                                                                            @if($budget->project_phase == $distinct_phase->project_phase && $budget->amendment==$distinct_phase->amendment)
                                                                                @if($budget->is_amendment==1)
                                                                                    <div style="display: none">
                                                                                        {{$checking1=1}}
                                                                                    </div>

                                                                                @endif
                                                                                <tr>
                                                                                    <td>{{ $i++ }}</td>
                                                                                    <td>{{ $budget->expense_name }}</td>
                                                                                    <td> {{ $budget->unit }}</td>
                                                                                    <td> {{ $budget->unit_cost }}</td>
                                                                                    <td> {{ $budget->quantity }}</td>
                                                                                    <td> {{ number_format($budget->total_amount,2,".",",") }}</td>
                                                                                    @php $total_amount += $budget->total_amount @endphp
                                                                                    <td>
                                                                                        @foreach($users as $creator)
                                                                                                    @if( $budget->created_by == $creator->id )
                                                                                                        {{$creator->name}}
                                                                                                    @endif
                                                                                                @endforeach
                                                                                            </td>
                                                                                            <td>{{ date('d-M-Y', strtotime($budget->created_at)) }}</td>
                                                                                            <td>
                                                                                                <a href="#budgetModal"
                                                                                                   data-toggle="modal"
                                                                                                   data-target="#budgetModal_{{ $budget->id}}"
                                                                                                   data-id="{{$budget->id}}">
                                                                                                    <button
                                                                                                        type="button"
                                                                                                        class="btn btn-info action-icon">
                                                                                                        <i class="fa fa-edit"></i>
                                                                                                    </button>
                                                                                                </a>

                                                                                                @hasrole('Super Admin')
                                                                                                <a class="modalLink"
                                                                                                   title="Delete"
                                                                                                   data-modal-size="modal-md"
                                                                                                   href="{{url('deleteProjectBudgetView', $budget->id)}}">
                                                                                                    <button
                                                                                                        type="button"
                                                                                                        class="btn btn-danger action-icon">
                                                                                                        <i class="fa fa-trash-o"></i>
                                                                                                    </button>
                                                                                                </a>
                                                                                                @endhasrole

                                                                                                <div class="modal fade"
                                                                                                     id="budgetModal_{{ $budget->id}}"
                                                                                                     role="dialog">
                                                                                                    <div
                                                                                                        class="modal-dialog modal-lg">

                                                                                                        <!-- Modal content-->
                                                                                                        <div
                                                                                                            class="modal-content form-group col-md-12">
                                                                                                            <div
                                                                                                                class="modal-header">
                                                                                                                <h4 class="modal-title"
                                                                                                                    style="color:#000000">{{$budget->expense_name}}</h4>
                                                                                                            </div>
                                                                                                            <div
                                                                                                                class="modal-body">
                                                                                                                {{ Form::open(['class' => '', 'files' => true, 'url' => 'project/budget_edit/'.$budget->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                                                                                                <div
                                                                                                                    class="form-group col-md-10">
                                                                                                                    <label
                                                                                                                        for="employee"><strong>
                                                                                                                            Amendment
                                                                                                                            No:</strong></label>
                                                                                                                    <select
                                                                                                                        class="js-example-basic-single col-sm-12 {{ $errors->has('amendment') ? ' is-invalid' : '' }}"
                                                                                                                        name="amendment"
                                                                                                                        id="amendment">
                                                                                                                        <option
                                                                                                                            value="">
                                                                                                                            Select
                                                                                                                            Amendment
                                                                                                                            No
                                                                                                                        </option>
                                                                                                                        @if(isset($maxAmendmentBudget))
                                                                                                                            @for($iy=1; $iy<=$maxAmendmentBudget; $iy++)
                                                                                                                                <option
                                                                                                                                    value="{{ $iy}}">{{$iy}}</option>
                                                                                                                            @endfor
                                                                                                                        @endif
                                                                                                                    </select>
                                                                                                                </div>

                                                                                                                <div
                                                                                                                    class="form-group col-md-10">
                                                                                                                    <label
                                                                                                                        for="expense_name"><strong>Expense
                                                                                                                            Name:</strong></label>
                                                                                                                    <input
                                                                                                                        type="text"
                                                                                                                        class="form-control {{ $errors->has('expense_name') ? ' is-invalid' : '' }}"
                                                                                                                        value="{{ $budget->expense_name }}"
                                                                                                                        name="expense_name"
                                                                                                                        required/>
                                                                                                                    @if ($errors->has('expense_name'))
                                                                                                                        <span
                                                                                                                            class="invalid-feedback"
                                                                                                                            role="alert">
                                                                                            <span
                                                                                                class="messages"><strong>{{ $errors->first('expense_name') }}</strong></span>
                                                                                        </span>
                                                                                                                    @endif
                                                                                                                </div>

                                                                                                                <div
                                                                                                                    class="form-group col-md-10">
                                                                                                                    <label
                                                                                                                        for="unit"><strong>Unit:</strong></label>
                                                                                                                    <input
                                                                                                                        type="text"
                                                                                                                        class="form-control {{ $errors->has('unit') ? ' is-invalid' : '' }}"
                                                                                                                        value="{{ $budget->unit }}"
                                                                                                                        name="unit"/>
                                                                                                                    @if ($errors->has('unit'))
                                                                                                                        <span
                                                                                                                            class="invalid-feedback"
                                                                                                                            role="alert">
                                                                                                <span
                                                                                                    class="messages"><strong>{{ $errors->first('unit') }}</strong></span>
                                                                                            </span>
                                                                                                                    @endif
                                                                                                                </div>

                                                                                                                <div
                                                                                                                    class="form-group col-md-10">
                                                                                                                    <label
                                                                                                                        for="unit_cost"><strong>Unit
                                                                                                                            Cost
                                                                                                                            (BDT):</strong></label>
                                                                                                                    <input
                                                                                                                        type="number"
                                                                                                                        step="0.01"
                                                                                                                        class="form-control {{ $errors->has('unit_cost') ? ' is-invalid' : '' }}"
                                                                                                                        value="{{ $budget->unit_cost }}"
                                                                                                                        name="unit_cost"
                                                                                                                        required/>
                                                                                                                    @if ($errors->has('unit_cost'))
                                                                                                                        <span
                                                                                                                            class="invalid-feedback"
                                                                                                                            role="alert">
                                                                                                <span
                                                                                                    class="messages"><strong>{{ $errors->first('unit_cost') }}</strong></span>
                                                                                            </span>
                                                                                                                    @endif
                                                                                                                </div>

                                                                                                                <div
                                                                                                                    class="form-group col-md-10">
                                                                                                                    <label
                                                                                                                        for="quantity"><strong>Quantity:</strong></label>
                                                                                                                    <input
                                                                                                                        type="number"
                                                                                                                        step="0.01"
                                                                                                                        class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}"
                                                                                                                        value="{{ $budget->quantity }}"
                                                                                                                        name="quantity"
                                                                                                                        required/>
                                                                                                                    @if ($errors->has('quantity'))
                                                                                                                        <span
                                                                                                                            class="invalid-feedback"
                                                                                                                            role="alert">
                                                                                                <span
                                                                                                    class="messages"><strong>{{ $errors->first('quantity') }}</strong></span>
                                                                                            </span>
                                                                                                                    @endif
                                                                                                                </div>

                                                                                                                <div
                                                                                                                    class="form-group col-md-2">
                                                                                                                    <label
                                                                                                                        for="submit"></label>
                                                                                                                    <input
                                                                                                                        type="submit"
                                                                                                                        class="form-control btn btn-primary m-b-0"
                                                                                                                        style="margin-top: 5px;"/>
                                                                                                                </div>
                                                                                                                {{ Form::close()}}
                                                                                                            </div>

                                                                                                            <div
                                                                                                                class="modal-footer">
                                                                                                                <button
                                                                                                                    type="button"
                                                                                                                    class="btn btn-danger"
                                                                                                                    data-dismiss="modal">
                                                                                                                    Close
                                                                                                                </button>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                            </tbody>
                                                                            <tr>
                                                                                <td></td>
                                                                                <th colspan="4">Total</th>
                                                                                <th> {{ number_format($total_amount,2,".",",") }}</th>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            @endforeach
                                        @endif


                                        <div class="text-bottom text-center pt-5 mt-5 footer" style="display: none"
                                             id="footer">
                                            <div class="row">
                                                <div class="col">
                                                    <p style="font-size: 0.9rem; background-color: #ece7e4; color: black">
                                                        ERP Version 1.1 | Developed by: White Paper | Printed
                                                        By: {{ Auth::user()->name }} | <span id="datetime2"></p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="advance" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    @if( isset($editData->project_name) )
                                        <h5 class="card-header-text"
                                            style="font-size: 1rem;">{{ $editData->project_name }}</h5>
                                    @else
                                        <h5 class="card-header-text">No Project Name</h5>
                                    @endif
                                    <br>
                                    <a href="{{ url('project_advance/create',$editData->id) }}"
                                       style="float: right; padding: 10px; color: white;" class="btn btn-success"> Add
                                        Advance Payment </a>
                                    <a href="{{ url('project/advance/amendment/create',$editData->id) }}"
                                       style="float: right; padding: 10px; color: white;margin-right: 10px"
                                       class="btn btn-success"> Add Amendment </a>
                                </div>

                                @if(isset($distinct_advance_phase))
                                    @foreach( $distinct_advance_phase as $distinct_phase)
                                        <div class="card-block">
                                            @php $total_amount = 0; $total_credit = 0 @endphp
                                            <div class="card">
                                                <div class="card-header">
                                                    <strong>
                                                        @foreach($phases as $phase)
                                                            @if( $distinct_phase->project_phase == $phase->defined_id )
                                                                PHASE -
                                                                00{{$phase->defined_id}} {{$phase->name}}
                                                            @endif
                                                        @endforeach
                                                    </strong>
                                                </div>
                                                @if($distinct_phase->amendment != 0)
                                                    <div class="card-header">

                                                        <strong style="color: #00aeef">
                                                            Amendment No: {{$distinct_phase->amendment}}
                                                        </strong>

                                                    </div>
                                                @endif
                                                @if($distinct_phase->amendment==0)
                                                    <div class="card-header">

                                                        <strong style="color: #00aeef">
                                                            Original Contract
                                                        </strong>

                                                    </div>
                                                @endif
                                                <div class="card-block">
                                                    <div class="table-responsive">
                                                        <table id="advance_table"
                                                               class="table table-striped table-bordered payment_table">
                                                            <thead>
                                                            <tr>
                                                                <th>Sl No.</th>
                                                                <th>Amount</th>
                                                                <th>Receive Date</th>
                                                                <th>Bank Name</th>
                                                                <th>Guarantee Amount</th>
                                                                <th>Effective Date Through</th>
                                                                <th>Recorded By</th>
                                                                <th>Recorded On</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @if(isset($editData->advances))
                                                                @php $i = 1;$checking2 = 0; @endphp
                                                                @foreach($editData->advances as $advance)
                                                                    @if($advance->project_phase == $distinct_phase->project_phase && $advance->amendment==$distinct_phase->amendment)

                                                                        @if($advance->is_amendment==1)
                                                                            <div style="display: none">
                                                                                {{$checking2=1}}
                                                                            </div>

                                                                        @endif
                                                                        <tr>
                                                                            <td>{{ $i++ }}</td>
                                                                            <td> {{ number_format($advance->amount,2,".",",") }}</td>
                                                                            @php $total_amount += $advance->amount @endphp
                                                                            <td>
                                                                                @if(isset($advance->receive_date))
                                                                                    {{ date('d-M-Y', strtotime($advance->receive_date)) }}
                                                                                @endif
                                                                            </td>
                                                                            <td> {{ $advance->bank_name }}</td>
                                                                            <td> {{ $advance->guarantee_amount }}</td>
                                                                            <td>
                                                                                @if(isset($advance->effective_through))
                                                                                    {{ date('d-M-Y', strtotime($advance->effective_through)) }}
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                @foreach($users as $creator)
                                                                                    @if( $advance->created_by == $creator->id )
                                                                                        {{$creator->name}}
                                                                                    @endif
                                                                                @endforeach
                                                                            </td>
                                                                            <td>{{ date('d-M-Y', strtotime($advance->created_at)) }}</td>
                                                                            <td>
                                                                                <a href="{{ url('project_advance/'.$advance->id.'/edit') }}"
                                                                                   title="Edit">
                                                                                    <button type="button"
                                                                                            class="btn btn-info action-icon">
                                                                                        <i class="fa fa-edit"></i>
                                                                                    </button>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                            </tbody>
                                                            <tr>

                                                                <th>Total</th>
                                                                <th> {{ number_format($total_amount,2,".",",") }}</th>
                                                                <td colspan="7"></td>

                                                            </tr>
                                                            {{--                                            <tr>--}}
                                                            {{--                                                <td></td>--}}
                                                            {{--                                                <th colspan="4">Total</th>--}}
                                                            {{--                                                <th> {{ number_format($total_amount,2,".",",") }}</th>--}}
                                                            {{--                                                <td></td>--}}
                                                            {{--                                                <td></td>--}}
                                                            {{--                                                <td></td>--}}
                                                            {{--                                            </tr>--}}
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                    @endif
                    @if($editData->project_phase >= 3)

                        <div class="tab-pane" id="progress" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    @if( isset($editData->project_name) )
                                        <h5 class="card-header-text"
                                            style="font-size: 1rem;">{{ $editData->project_name }}</h5>
                                    @else
                                        <h5 class="card-header-text">No Project Name</h5>
                                    @endif
                                    <br>
                                    <button onclick="printProgressPayment('ProgressPayment')"
                                            style="padding: 8px; margin-right: 10px; color: white;float: right;"
                                            class="btn btn-success"> Print Progress payment
                                    </button>
                                    <a href="{{ url('project_progress/create',$editData->id) }}"
                                       style="float: right; padding: 8px; color: white;margin-right: 10px;"
                                       class="btn btn-success"> Add
                                        progress Payment </a>
                                    <a href="{{ url('project/progress/amendment/create',$editData->id) }}"
                                       style="float: right; padding: 8px; color: white;margin-right: 10px"
                                       class="btn btn-success"> Add Amendment </a>


                                </div>

                                <div class="card-block" id="ProgressPayment">
                                    <div class="logo row" id="logo" style="display:none;">
                                        <div class="col-md-4"
                                             style="padding-left:5%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
                                            <img class="img-fluid"
                                                 src="{{asset('public/assets/images/epc_logo.png')}}"
                                                 height="10" width="120">
                                        </div>
                                        <div class="col-md-4"
                                             style="padding-left:5%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
                                            <p style="margin-top: 25px; font-size: 22px; font-weight: bold;">{{ $editData->project_name }}
                                                Project Progress Payment List</p>
                                        </div>
                                    </div>
                                    @if(isset($distinct_progress_phase))
                                        @foreach( $distinct_progress_phase as $distinct_phase)
                                            <div class="card-block">
                                                @php $total_invoice_amount = 0; $total_receive_amount = 0 @endphp
                                                <div class="card">
                                                    <div class="card-header">
                                                        <strong>
                                                            @foreach($phases as $phase)
                                                                @if( $distinct_phase->project_phase == $phase->defined_id )
                                                                    PHASE -
                                                                    00{{$phase->defined_id}} {{$phase->name}}
                                                                @endif
                                                            @endforeach
                                                        </strong>
                                                    </div>
                                                    @if($distinct_phase->amendment!=0)
                                                        <div class="card-header">

                                                            <strong style="color: #00aeef">
                                                                Amendment No: {{$distinct_phase->amendment}}
                                                            </strong>

                                                        </div>
                                                    @endif
                                                    @if($distinct_phase->amendment==0)
                                                        <div class="card-header">

                                                            <strong style="color: #00aeef">
                                                                Original Contract
                                                            </strong>

                                                        </div>
                                                    @endif
                                                    <div class="card-block">
                                                        <div class="table-responsive">
                                                            <table id="advance_table"
                                                                   class="table table-striped table-bordered payment_table">
                                                                <thead>
                                                                <tr>
                                                                    <th>Sl No.</th>
                                                                    <th>phase No</th>
                                                                    <th>Payment No</th>
                                                                    <th>Payment Month</th>
                                                                    <th>Invoice Date</th>
                                                                    <th>Invoice Amount</th>
                                                                    <th>Receive Date</th>
                                                                    <th>Receive Amount</th>
                                                                    <th>Recorded By</th>
                                                                    <th>Recorded On</th>
                                                                    <th>description</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @if(isset($editData->progresses))
                                                                    @php $i = 1;$checking3 = 0; @endphp
                                                                    @foreach($editData->progresses as $progress)
                                                                        @if($progress->project_phase == $distinct_phase->project_phase && $progress->amendment == $distinct_phase->amendment)
                                                                            @if($progress->is_amendment==1)
                                                                                <div style="display: none">
                                                                                    {{$checking3=1}}
                                                                                </div>
                                                                            @endif
                                                                            <tr>
                                                                                <td>{{ $i++ }}</td>
                                                                                <td>00{{$progress->project_phase}}</td>
                                                                                <td>{{$progress->p_payment_no}}</td>
                                                                                <td>
                                                                                    {{$progress->p_payment_month}}
                                                                                </td>
                                                                                <td>
                                                                                    @if(isset($progress->invoice_date))
                                                                                        {{ date('d-M-Y', strtotime($progress->invoice_date)) }}
                                                                                    @endif
                                                                                </td>

                                                                                <td> {{ number_format($progress->invoice_amount,2,".",",") }}</td>
                                                                                @php $total_invoice_amount += $progress->invoice_amount @endphp
                                                                                <td>
                                                                                    @if(isset($progress->receive_date))
                                                                                        {{ date('d-M-Y', strtotime($progress->receive_date)) }}
                                                                                    @else
                                                                                        No Input given
                                                                                    @endif
                                                                                </td>
                                                                                <td>
                                                                                    @if(isset($progress->receive_amount))
                                                                                        {{ number_format($progress->receive_amount,2,".",",") }}
                                                                                    @else
                                                                                        No Input given
                                                                                    @endif
                                                                                </td>
                                                                                @php $total_receive_amount += $progress->receive_amount @endphp


                                                                                <td>
                                                                                    @foreach($users as $creator)
                                                                                        @if( $progress->created_by == $creator->id )
                                                                                            {{$creator->name}}
                                                                                        @endif
                                                                                    @endforeach
                                                                                </td>
                                                                                <td>{{ date('d-M-Y', strtotime($progress->created_at)) }}</td>
                                                                                <td>{{$progress->description}}</td>
                                                                                <td>
                                                                                    <a href="{{ url('project_progressPayment/'.$progress->id.'/edit') }}"
                                                                                       title="Edit">
                                                                                        <button type="button"
                                                                                                class="btn btn-info action-icon">
                                                                                            <i class="fa fa-edit"></i>
                                                                                        </button>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                                </tbody>
                                                                <tr>
                                                                    <td></td>
                                                                    <th colspan="4" class="text-center">Invoice Payment
                                                                        Total
                                                                    </th>
                                                                    <th> {{ number_format($total_invoice_amount,2,".",",") }}</th>
                                                                    <th colspan="1" class="text-center">Received Payment
                                                                        Total
                                                                    </th>
                                                                    <th colspan="1"
                                                                        class="text-left">{{ number_format($total_receive_amount,2,".",",") }}</th>
                                                                    <th colspan="5"></th>

                                                                </tr>
                                                                {{--                                            <tr>--}}
                                                                {{--                                                <td></td>--}}
                                                                {{--                                                <th colspan="4">Total</th>--}}
                                                                {{--                                                <th> {{ number_format($total_amount,2,".",",") }}</th>--}}
                                                                {{--                                                <td></td>--}}
                                                                {{--                                                <td></td>--}}
                                                                {{--                                                <td></td>--}}
                                                                {{--                                            </tr>--}}
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @endforeach
                                    @endif


                                    <div class="text-bottom text-center pt-5 mt-5 footer"
                                         style="display: none"
                                         id="footer">
                                        <div class="row">
                                            <div class="col">
                                                <p style="font-size: 0.9rem; background-color: #ece7e4; color: black">
                                                    ERP Version 1.1 | Developed by: White Paper |
                                                    Printed
                                                    By: {{ Auth::user()->name }} | <span
                                                        id="datetime13"></p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif
                    {{--// BUDGET TAB ENDS--}}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#project_employee').DataTable();
    $('#budget_table').DataTable();

    function printEmployeesDiv(project_employees) {
        $('.back_btn').hide();
        $('.logo').show();
        $('.footer').show();
        var dt = new Date();
        document.getElementById("datetime1").innerHTML = dt.toLocaleString();

        var printContents = document.getElementById(project_employees).innerHTML;
        var project_id = document.getElementById('project_id').value;
        var project_name = document.getElementById('project_name').value;
        document.body.innerHTML = printContents;
        document.title = project_name + ' Employees List';
        window.print();
        window.location.href = "/epc/project/" + project_id;
    }

    function printExpensesDiv(project_expenses) {
        $('.back_btn').hide();
        $('.logo').show();
        $('.footer').show();
        var dt = new Date();
        document.getElementById("datetime1").innerHTML = dt.toLocaleString();
        document.getElementById("datetime2").innerHTML = dt.toLocaleString();

        var printContents = document.getElementById(project_expenses).innerHTML;
        var project_id = document.getElementById('project_id').value;
        var project_name = document.getElementById('project_name').value;
        document.body.innerHTML = printContents;
        document.title = project_name + ' Expenses List';
        window.print();
        window.location.href = "/epc/project/" + project_id;
    }

    function printProgressPayment(ProgressPayment) {
        $('.back_btn').hide();
        $('.logo').show();
        $('.footer').show();
        var dt = new Date();
        document.getElementById("datetime13").innerHTML = dt.toLocaleString();

        var printContents = document.getElementById(ProgressPayment).innerHTML;
        var project_id = document.getElementById('project_id').value;
        var project_name = document.getElementById('project_name').value;
        document.body.innerHTML = printContents;
        document.title = project_name + ' Progress Payment List';
        window.print();
        window.location.href = "/epc/project/" + project_id;
    }

</script>

