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
            <input type="text" id="employee_id" value="{{ $editData->id }}" hidden>
            <div class="col-xl-3">
                <div class="card user-card">
                    <div class="card-header-img">
                        @if( isset($editData->employee_photo) )
                            <img class="img-fluid img-radius" style="margin-top: 20px;" src="{{ asset($editData->employee_photo) }}" alt="card-img">
                        @else
                            <img class="img-fluid img-radius" src="{{ asset('/public/images/no_image.png') }}" alt="card-img">
                        @endif

                        @if( isset($editData->first_name) )
                            <h4>{{ $editData->first_name.' '.$editData->last_name}}</h4>
                        @else
                            <h4>No Name</h4>
                        @endif

                        @if( isset($editData->unique_id) )
                            <h4>{{ $editData->unique_id }}</h4>
                        @else
                            <h4></h4>
                        @endif

                        @if( isset($editData->email) )
                            <h5>{{ $editData->email }}</h5>
                        @else
                            <h5>No Email</h5>
                        @endif

                        @if( isset($editData->designation_id))
                            <h6>{{ $editData->designation->designation_name }}</h6>
                        @else
                            <h6>No Designation</h6>
                        @endif
                    </div>

                    <div style="text-align: center;">
                        @if( isset($editData->employee_status) && $editData->employee_status == 1 )
                            <button type="button" class="btn btn-success waves-effect waves-light m-r-15">Active</button>
                        @else
                            <button type="button" class="btn btn-success waves-effect waves-light">In-active</button>
                        @endif
                    </div>

                    <div style="text-align: center;">
                        @if( isset($editData->mobile) )
                            <button type="button" class="btn btn-primary waves-effect waves-light m-r-15">{{ $editData->mobile }}</button>
                        @else
                            <button type="button" class="btn btn-primary waves-effect waves-light">No Number</button>
                        @endif

                        @if( isset($editData->room_no))
                            <a href="{{url('location/assets/'.$editData->room_no)}}" title="assets"><button type="button" class="btn btn-primary waves-effect waves-light">Room No. {{ $editData->room->room_no }}</button></a>
                        @else
                            <button type="button" class="btn btn-primary waves-effect waves-light">No Room No.</button>
                        @endif
                    </div>
                </div>
                @if(Auth::user()->hasPermissionTo('View Employee List') || Auth::user()->getRoleNames()->first() == 'Super Admin')
                    <div class="text-center">
                        <a class="" title="Back" href="{{url('/employee')}}">
                            <button type="button" class="btn btn-primary m-b-0">Employees List</button>
                        </a>
                    </div>
                @endif
            </div>

            <div class="col-xl-9">
                <div class="tab-header card">
                    <ul class="nav nav-tabs nav-fill tab-timeline" role="tablist" id="mytab">
                        @if(Auth::user()->hasPermissionTo('View Employee Details') || Auth::user()->employee_id == $editData->id|| Auth::user()->getRoleNames()->first() == 'Super Admin')
                            <li class="nav-item">
                                <a class="nav-link active tab_style" data-toggle="tab" href="#personal" role="tab">Personal Details</a>
                                <div class="slide"></div>
                            </li>
                        @endif
                        @if(Auth::user()->hasPermissionTo('View Employee Salary') || Auth::user()->employee_id == $editData->id|| Auth::user()->getRoleNames()->first() == 'Super Admin')
                            <li class="nav-item">
                                <a class="nav-link tab_style" data-toggle="tab" href="#employee_salary" role="tab">Employee Salary</a>
                            </li>
                        @endif
                        @if(Auth::user()->hasPermissionTo('View Employee Leave') || Auth::user()->employee_id == $editData->id|| Auth::user()->getRoleNames()->first() == 'Super Admin')
                            <li class="nav-item">
                                <a class="nav-link tab_style " data-toggle="tab" href="#leave" role="tab">Leave</a>
                            </li>
                        @endif
                        @if(Auth::user()->hasPermissionTo('View Employee Attendance History') || Auth::user()->employee_id == $editData->id|| Auth::user()->getRoleNames()->first() == 'Super Admin')
                            <li class="nav-item">
                                <a class="nav-link tab_style" data-toggle="tab" href="#attendance_history" role="tab">Attendence history</a>
                            </li>
                        @endif
                        @if(Auth::user()->hasPermissionTo('View Employee Tasks') || Auth::user()->employee_id == $editData->id|| Auth::user()->getRoleNames()->first() == 'Super Admin')
                            <li class="nav-item">
                                <a class="nav-link tab_style" data-toggle="tab" href="#task" role="tab">Tasks</a>
                            </li>
                        @endif
                        @if(Auth::user()->hasPermissionTo('View Employee Materials') || Auth::user()->employee_id == $editData->id|| Auth::user()->getRoleNames()->first() == 'Super Admin')
                            <li class="nav-item">
                                <a class="nav-link tab_style" data-toggle="tab" href="#materials" role="tab">Materials</a>
                            </li>
                        @endif
                        @if(Auth::user()->hasPermissionTo('View Employee Document') || Auth::user()->employee_id == $editData->id|| Auth::user()->getRoleNames()->first() == 'Super Admin')
                            <li class="nav-item">
                                <a class="nav-link tab_style" data-toggle="tab" href="#document" role="tab">Documents</a>
                            </li>
                        @endif
                    </ul>
                </div>

                <div class="tab-content">
                    <div class="tab-pane active" id="personal" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-header-text">Details</h5>
                                <a class="" title="Print Details" href="{{url('employee/print',$editData->id)}}" target="_blank">
                                    <button class="btn btn-success" style="float: right; padding: 6px 25px;">Print Details</button>
                                </a>
                                <a class="" title="Print Certificate" href="{{url('employee/printCertificate',$editData->id)}}" target="_blank">
                                    <button class="btn btn-success" style="float: right; padding: 6px 10px; margin-right: 10px">Employee Certificate</button>
                                </a>
                            </div>
                            <div class="card-block">
                                <div class="view-info">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="general-info">
                                                <div class="row">
                                                    <div class="col-lg-12 ">
                                                        <div class="table-responsive">
                                                            <table class="table m-0">
                                                                <tbody>

                                                                <!-- PERSONAL ROW 1 : FULL NAME, JOINING DATE -->
                                                                <tr>
                                                                    <th scope="col">Full Name</th>

                                                                    @if( isset($editData->first_name) || isset($editData->last_name))
                                                                        <td>{{ $editData->first_name .' '. $editData->last_name }}</td>
                                                                    @else
                                                                        <td>No Name</td>
                                                                    @endif

                                                                    <th scope="row">Joining Date</th>
                                                                    @if( isset($editData->joining_date) )
                                                                        <td>{{ date('d-M-Y', strtotime($editData->joining_date)) }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <!-- PERSONAL ROW 2 : DEPT NAME, DESIGNATION NAME -->
                                                                <tr>
                                                                    <th scope="row">Department name</th>
                                                                    @if( isset($editData->department_id))
                                                                        <td>{{ $editData->department->department_name }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif

                                                                    <th scope="row">Designation name</th>
                                                                    @if( isset($editData->designation_id))
                                                                        <td>{{ $editData->designation->designation_name }}</td>
                                                                    @else
                                                                        <td>No Designation</td>
                                                                    @endif
                                                                </tr>

                                                                <!-- PERSONAL ROW 3 : EMAIL, EMPLOYEE ATATUS -->
                                                                <tr>
                                                                    <th scope="row">Email</th>
                                                                    @if( isset($editData->email) )
                                                                        <td>{{ $editData->email }}</td>
                                                                    @else
                                                                        <td>No Email</td>
                                                                    @endif

                                                                    <th scope="row">Employment Status</th>
                                                                    @if( isset($editData->employee_type))
                                                                        <td>{{ $editData->type->type_name }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <!-- PERSONAL ROW 4 : CONTACT NO, EMERGENCY NO -->
                                                                <tr>
                                                                    <th scope="row">Contact no.</th>
                                                                    @if( isset($editData->mobile) )
                                                                        <td>{{ $editData->mobile }}</td>
                                                                    @else
                                                                        <td>No phone number given</td>
                                                                    @endif

                                                                    <th scope="row">Emergency no.</th>
                                                                    @if( isset($editData->emergency_no) )
                                                                        <td>{{ $editData->emergency_no }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <!-- PERSONAL ROW 5 : DOB, PLACE OF BIRTH -->
                                                                <tr>
                                                                    <th scope="row">Birth Date</th>
                                                                    @if( isset($editData->date_of_birth) )
                                                                        <td>{{ date('d-M-Y', strtotime($editData->date_of_birth)) }}</td>
                                                                    @else
                                                                        <td>No birth date given</td>
                                                                    @endif

                                                                    <th scope="row">Place of Birth</th>
                                                                    @if( isset($editData->place_of_birth) )
                                                                        <td>{{ $editData->place_of_birth }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <!-- PERSONAL ROW 6 : BLOOD GROUP, GENDER -->
                                                                <tr>
                                                                    <th scope="row">Blood Group</th>
                                                                    @if( isset($blood_groups) && isset($editData->blood_group_id))
                                                                        @foreach($blood_groups as $blood_group)
                                                                            @if($blood_group->id == $editData->blood_group_id)
                                                                                <td>{{ $blood_group->base_setup_name }}</td>
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif

                                                                    <th scope="row">Gender</th>
                                                                    @if( isset($genders) && isset($editData->gender_id))
                                                                        @foreach($genders as $gender)
                                                                            @if($gender->id == $editData->gender_id)
                                                                                <td>{{ $gender->base_setup_name }}</td>
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Location</th>
                                                                    @if( isset($projects) && isset($editData->location))
                                                                        @if($editData->location == 0)
                                                                            <td>Head Office</td>
                                                                        @else
                                                                            @foreach($projects as $project)
                                                                                @if($project->id == $editData->location)
                                                                                    <td>{{ $project->project_name }}</td>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif

                                                                    <th scope="row">Room Number</th>
                                                                    @if( isset($editData->room_no))
                                                                        <td>{{ $editData->room->room_no }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <!-- PERSONAL ROW 7 : PRESENT ADDRESS -->
                                                                <tr>
                                                                    <th scope="row">Present Address</th>
                                                                    @if( isset($editData->current_address) )
                                                                        <td colspan="3">{{ $editData->current_address }}</td>
                                                                    @else
                                                                        <td colspan="3">No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <!-- PERSONAL ROW 7 : PERMANENT ADDRESS -->
                                                                <tr>
                                                                    <th scope="row">Permanent Address</th>
                                                                    @if( isset($editData->permanent_address) )
                                                                        <td colspan="3">{{ $editData->permanent_address }}</td>
                                                                    @else
                                                                        <td colspan="3">No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <!-- PERSONAL ROW 8 : NID, TIN -->
                                                                <tr>
                                                                    <th scope="row">NID</th>
                                                                    @if( isset($editData->nid) )
                                                                        <td>{{ $editData->nid }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif

                                                                    <th scope="row">TIN</th>
                                                                    @if( isset($editData->tin) )
                                                                        <td>{{ $editData->tin }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <!-- PERSONAL ROW 9 : QUALIFICATIONS -->
                                                                <tr>
                                                                    <th scope="row">Qualifications</th>
                                                                    @if( isset($editData->qualifications) )
                                                                        <td colspan="3">{{ $editData->qualifications }}</td>
                                                                    @else
                                                                        <td colspan="3">No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <!-- PERSONAL ROW 10 : EXPERIENCE -->
                                                                <tr>
                                                                    <th scope="row">Experiences</th>
                                                                    @if( isset($editData->experiences) )
                                                                        <td colspan="3">{{ $editData->experiences }}</td>
                                                                    @else
                                                                        <td colspan="3">No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <!-- PERSONAL ROW 11 : YES/NO INFO -->
                                                                <tr>
                                                                    <th scope="row">Previous Employment with EPC? <br> If yes, then when?</th>
                                                                    @if( isset($editData->family->epc_before) )
                                                                        @if($editData->family->epc_before == 1)
                                                                            <td>Yes</td>
                                                                            @if( isset($editData->family->epc_before_from) )
                                                                                <td>From: {{ date('d-M-Y', strtotime($editData->family->epc_before_from)) }}</td>
                                                                            @endif
                                                                            @if( isset($editData->family->epc_before_to) )
                                                                                <td>To: {{ date('d-M-Y', strtotime($editData->family->epc_before_to)) }}</td>
                                                                            @endif
                                                                        @else
                                                                            <td colspan="3">No</td>
                                                                        @endif
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <!-- PERSONAL ROW 12 : YES/NO INFO RELATIVES -->
                                                                <tr>
                                                                    <th scope="row">Friends/Relatives in EPC? <br> If yes, name and relation</th>
                                                                    @if( isset($editData->family->relative) )
                                                                        @if($editData->family->relative == 1)
                                                                            <td>Yes</td>
                                                                        @elseif($editData->family->relative == 0)
                                                                            <td>No</td>
                                                                        @endif
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif

                                                                    @if( isset($editData->family->relative_name) )
                                                                        <th>Relative Name</th>
                                                                        <td>{{ $editData->family->relative_name }}</td>
                                                                    @else
                                                                        <td colspan="3"></td>
                                                                    @endif
                                                                </tr>

                                                                <!-- FAMILY DETAILS -->
                                                                <!-- FAMILY ROW 1: FATHER'S NAME, MOTHER'S NAME -->
                                                                <tr>
                                                                    <th scope="row">Father's Name</th>
                                                                    @if( isset($editData->family->father_name) )
                                                                        <td>{{ $editData->family->father_name }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif

                                                                    <th scope="row">Mother's Name</th>
                                                                    @if( isset($editData->family->mother_name) )
                                                                        <td>{{ $editData->family->mother_name }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <!-- FAMILY ROW 2 : MARITAL STATUS, SPOUSE, CHILDREN NAMES -->
                                                                <tr>
                                                                    <th scope="row">Marital Status</th>
                                                                    @if( isset($editData->family->marital_status) )
                                                                        @if($editData->family->marital_status == 1)
                                                                            <td>Married</td>
                                                                        @elseif($editData->family->marital_status == 0)
                                                                            <td>Single</td>
                                                                        @endif
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif

                                                                    @if( isset($editData->family->spouse_name) )
                                                                        <th scope="row">Spouse Name</th>
                                                                        <td>{{ $editData->family->spouse_name }}</td>
                                                                    @else
                                                                        <th></th>
                                                                        <td></td>
                                                                    @endif
                                                                </tr>

                                                                @if( isset($editData->family->spouse_name) )
                                                                    <tr>
                                                                        <th scope="row">Child's Name(s)</th>
                                                                        <td colspan="3">{{ $editData->family->child_name}}</td>
                                                                    </tr>
                                                                @endif

                                                                <!-- BANK DETAILS -->
                                                                <!-- BANK ROW 1 : BANK NAME, ACCOUNT NUMBER -->
                                                                <tr>
                                                                    <th scope="row">Bank Name</th>
                                                                    @if( isset($editData->bank->bank_name) )
                                                                        <td>{{ $editData->bank->bank_name }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif

                                                                    <th scope="row">Account Number</th>
                                                                    @if( isset($editData->bank->account_number) )
                                                                        <td>{{ $editData->bank->account_number }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <!-- BANK ROW 2 : BANK ADDRESS, SWIFT NUMBER -->
                                                                <tr>
                                                                    <th scope="row">Bank Branck</th>
                                                                    @if( isset($editData->bank->bank_branch) )
                                                                        <td>{{ $editData->bank->bank_branch }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif

                                                                    <th scope="row">Bank Address</th>
                                                                    @if( isset($editData->bank->bank_address) )
                                                                        <td>{{ $editData->bank->bank_address }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Routing Number</th>
                                                                    @if( isset($editData->bank->routing_no) )
                                                                        <td>{{ $editData->bank->routing_no }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif

                                                                    <th scope="row">Swift Code</th>
                                                                    @if( isset($editData->bank->swift_code) )
                                                                        <td>{{ $editData->bank->swift_code }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <!-- ADDITIONAL INFORMATION    -->
                                                                <tr>
                                                                    <th scope="row">Added By</th>
                                                                    @if( isset($editData->created_by) )
                                                                        <td>
                                                                            @foreach($users as $user)
                                                                                @if( $editData->created_by == $user->id )
                                                                                    {{$user->name}}
                                                                                @endif
                                                                            @endforeach
                                                                        </td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif

                                                                    <th scope="row">Added On</th>
                                                                    @if( isset($editData->created_at) )
                                                                        <td>{{ date('d-M-Y', strtotime($editData->created_at)) }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="employee_salary" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 id="head">For the month of {{ $month }}</h5>
                                <a class="" title="Print" href="{{url('employee/printSalaryIndi',$editData->id)}}">
                                    <button class="btn btn-success printBtn" style="float: right; padding: 6px 25px;">Print Salary</button>
                                </a>
                            </div>
                            {{ Form::open(['class' => '', 'files' => true, 'url' => 'employee/printSalaryMonth/'.$editData->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                            {{csrf_field()}}
                            <div class="">
                                <div class="row">
                                    <div class="form-group row col-md-12">
                                        <div class="form-group col-md-4 offset-md-1">
                                            <label for="start_month"><strong> Select Start Month:</strong></label>
                                            <input type="" class="form-control datepicker {{ $errors->has('start_month') ? ' is-invalid' : '' }}" value="{{ old('start_month') }}" name="start_month" required placeholder="Select Start Month"/>
                                            @if ($errors->has('start_month'))
                                                <span class="invalid-feedback" role="alert">
                                                    <span class="messages"><strong>{{ $errors->first('start_month') }}</strong></span>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="end_month"><strong> Select End Month:</strong></label>
                                            <input type="" class="form-control datepicker {{ $errors->has('end_month') ? ' is-invalid' : '' }}" value="{{ old('end_month') }}" name="end_month" required placeholder="Select End Month"/>
                                            @if ($errors->has('end_month'))
                                                <span class="invalid-feedback" role="alert">
                                                    <span class="messages"><strong>{{ $errors->first('end_month') }}</strong></span>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="submit"></label>
                                            <input type="submit" class="form-control btn btn-primary m-b-0" value="Print" style="margin-top: 5px;"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{ Form::close()}}
                            <div class="card-block">
                                <div class="table table-responsive">
                                    <table class="table col-md-8 offset-md-2">
                                        <tr>
                                            <td>
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th colspan="2" style="text-align: center">GROSS SALARY</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <th>Gross Salary <span style="font-weight: normal; "> ( Including House rent, conveyance, medical )</span></th>
                                                        <td style="text-align: right">
                                                            @if( isset($salary) )
                                                                {{ $salary->present_salary }}
                                                            @else
                                                                0
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th colspan="2" style="text-align: center">OTHER ADDITION</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>Overtime</td>
                                                        <td style="text-align: right">
                                                            @if( isset($salary) )
                                                                {{ $salary->ot_time }}
                                                            @else
                                                                0
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    @if($salary->ot_conveyance > 0)
                                                        <tr>
                                                            <td>Overtime Conveyance</td>
                                                            <td style="text-align: right">{{ $salary->ot_conveyance }}</td>
                                                        </tr>
                                                    @endif
                                                    @if($salary->ot_food > 0)
                                                        <tr>
                                                            <td>Overtime Food</td>
                                                            <td style="text-align: right">{{ $salary->ot_food }}</td>
                                                        </tr>
                                                    @endif
                                                    @if($salary->ot_pay > 0)
                                                        <tr>
                                                            <td>Overtime Pay</td>
                                                            <td style="text-align: right">{{ $salary->ot_pay }}</td>
                                                        </tr>
                                                    @endif

                                                    @if($salary->eid_bonus > 0)
                                                        <tr>
                                                            <td>Eid Bonus</td>
                                                            <td style="text-align: right">{{ $salary->eid_bonus }}</td>
                                                        </tr>
                                                    @endif
                                                    @if($salary->annual_bonus > 0)
                                                        <tr>
                                                            <td>Annual Bonus</td>
                                                            <td style="text-align: right">{{ $salary->annual_bonus }}</td>
                                                        </tr>
                                                    @endif
                                                    @if($salary->transport_allowance > 0)
                                                        <tr>
                                                            <td>Transport Allowance</td>
                                                            <td style="text-align: right">{{ $salary->transport_allowance }}</td>
                                                        </tr>
                                                    @endif
                                                    @if($salary->mobile_allowance > 0)
                                                        <tr>
                                                            <td>Mobile Allowance</td>
                                                            <td style="text-align: right">{{ $salary->mobile_allowance }}</td>
                                                        </tr>
                                                    @endif
                                                    @if($salary->other_allowance > 0)
                                                        <tr>
                                                            <td>Other Allowance</td>
                                                            <td style="text-align: right">{{ $salary->other_allowance }}</td>
                                                        </tr>
                                                    @endif

                                                    <tr style="color: blue;">
                                                        <th>Total Addition</th>
                                                        <th style="text-align: right">
                                                            @if( isset($salary) )
                                                                {{ $salary->gross }}
                                                            @else
                                                                0
                                                            @endif
                                                        </th>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table class="table" id="deductives">
                                                    <thead>
                                                    <tr>
                                                        <th colspan="2" style="text-align: center">DEDUCTIVE</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>Provident Fund</td>
                                                        <td style="text-align: right">
                                                            @if( isset($salary->provident_fund) )
                                                                {{ $salary->provident_fund }}
                                                            @else
                                                                0
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Salary Advance</td>
                                                        <td style="text-align: right">
                                                            @php $amount = 0 @endphp
                                                            @if( isset($salary) )
                                                                {{ $salary->advance }}
                                                            @else
                                                                0
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr style="color: blue;">
                                                        <th>Total Deduction</th>
                                                        <th style="text-align: right">
                                                            @if( isset($salary) )
                                                                {{ $salary->total_deduction }}
                                                            @else
                                                                0
                                                            @endif
                                                        </th>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table class="table">
                                                    <tr>
                                                        <th>Net Salary (Before tax)</th>
                                                        <th style="text-align: right">
                                                            @if( isset($salary) )
                                                                {{ $salary->gross }}
                                                            @else
                                                                0
                                                            @endif
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>Tax Deducted at Source</th>
                                                        <th style="text-align: right">
                                                            @if( isset($salary) )
                                                                {{ $salary->tax_payable }}
                                                            @else
                                                                0
                                                            @endif
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>Advance Deductions</th>
                                                        <th style="text-align: right">
                                                            @if( isset($salary->total_deduction) )
                                                                {{ $salary->total_deduction }}
                                                            @else
                                                                0
                                                            @endif
                                                        </th>
                                                    </tr>
                                                    @if($salary->conveyance)
                                                        <tr>
                                                            <th>Conveyance Addition</th>
                                                            <th style="text-align: right">{{ $salary->conveyance }}</th>
                                                        </tr>
                                                    @endif
                                                    <tr style="color: blue">
                                                        <th>Net Salary (After tax)</th>
                                                        <th style="text-align: right">
                                                            @if( isset($salary) )
                                                                {{ $salary->net_salary }}
                                                            @else
                                                                0
                                                            @endif
                                                        </th>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="leave" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-header-text">Leave</h5>
                                @if( Auth::user()->employee_id == $editData->id || Auth::user()->getRoleNames()->first() == 'Super Admin' || Auth::user()->getRoleNames()->first() == 'Admin' || Auth::user()->getRoleNames()->first() == 'HR Admin')
                                    <a href="#leave_request" class="btn btn-success collapsible" data-toggle="collapse" aria-expanded="false" aria-controls="leave_request" style="float: right; padding: 8px; color: white;">Leave Request</a>
                                @endif
                            </div>
                            <div class="card-block">
                                <div class="collapse" id="leave_request">
                                    {{ Form::open(['class' => '', 'files' => true, 'url' => 'employee/leaveRequest/'.$editData->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-8">
                                                <div class="form-group row col-md-12">
                                                    <div class="form-group col-md-6">
                                                        <label for="type_of_leave"><span class="important">*</span> Type Of Leave:</label>
                                                        <select class="js-example-basic-single{{ $errors->has('type_of_leave') ? ' is-invalid' : '' }}" name="type_of_leave" id="type_of_leave" required >
                                                            <option value="">Select Type </option>
                                                            @if(isset($leave_types))
                                                                @foreach($leave_types as $leave_type)
                                                                    <option value="{{ $leave_type->id }}" {{ old('type_of_leave')== $leave_type->id ? 'selected' : old('type_of_leave')  }} >{{$leave_type->leave_type}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        @if ($errors->has('type_of_leave'))
                                                            <span class="invalid-feedback" role="alert">
                                                        <span class="messages"><strong>{{ $errors->first('type_of_leave') }}</strong></span>
                                                    </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        @if( Auth::user()->employee_id == $editData->id)
                                                            <label for="approved_by"><span class="important">*</span> Approved By</label>
                                                            <select class="js-example-basic-single col-sm-12 {{ $errors->has('approved_by') ? ' is-invalid' : '' }}" name="approved_by" id="approved_by" required >
                                                                <option value="">Select Approver</option>
                                                                @if(isset($users))
                                                                    @foreach($users as $user)
                                                                        @if(($user->getRoleNames()->first() == 'Super Admin' || $user->getRoleNames()->first() == 'Admin' || $user->getRoleNames()->first() == 'HR Admin') && Auth::user()->id != $user->id)
                                                                            <option value="{{ $user->id }}" {{ old('approved_by')== $user->name ? 'selected' : old('approved_by')  }} >{{$user->name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            @if ($errors->has('approved_by'))
                                                                <span class="invalid-feedback" role="alert">
                                                            <span class="messages"><strong>{{ $errors->first('approved_by') }}</strong></span>
                                                        </span>
                                                            @endif
                                                        @endif

                                                        @if( Auth::user()->employee_id != $editData->id && (Auth::user()->getRoleNames()->first() == 'Super Admin' || Auth::user()->getRoleNames()->first() == 'Admin' || Auth::user()->getRoleNames()->first() == 'HR Admin') )
                                                            <label for="leave_document"><span class="important">*</span> Leave document</label>
                                                            <input class="form-control" name="leave_document" type="file" id="leave_document" required>
                                                            @if ($errors->has('leave_document'))
                                                                <span class="invalid-feedback" role="alert" >
                                                                <span class="messages"><strong>{{ $errors->first('leave_document') }}</strong></span>
                                                            </span>
                                                            @endif
                                                        @endif

                                                    </div>
                                                </div>

                                                <div class="form-group row input-effect col-md-12">
                                                    <div class="form-group col-md-6">
                                                        <label for="start_date"><span class="important">*</span> Start Date</label>
                                                        <input type="" class="form-control datepicker {{ $errors->has('start_date') ? ' is-invalid' : '' }}" value="{{ old('start_date') }}" name="start_date" required />
                                                        @if ($errors->has('start_date'))
                                                            <span class="invalid-feedback" role="alert" >
                                                            <span class="messages"><strong>{{ $errors->first('start_date') }}</strong></span>
                                                        </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="end_date"><span class="important">*</span> End Date</label>
                                                        <input type="" class="form-control datepicker {{ $errors->has('end_date') ? ' is-invalid' : '' }}" value="{{ old('end_date') }}" name="end_date" required/>
                                                        @if ($errors->has('end_date'))
                                                            <span class="invalid-feedback" role="alert" >
                                                            <span class="messages"><strong>{{ $errors->first('end_date') }}</strong></span>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row col-md-12">
                                                    <div class="form-group col-md-12">
                                                        <label for="reason"><span class="important">*</span> Reason for Leave</label>
                                                        <div id="casual_reason">
                                                            <select class="js-example-basic-single{{ $errors->has('reason') ? ' is-invalid' : '' }}" name="reason">
                                                                <option value="">Select Reason </option>
                                                                @if(isset($leave_reasons))
                                                                    @foreach($leave_reasons as $leave_reason)
                                                                        <option value="{{ $leave_reason->reason }}" {{ old('reason')== $leave_reason->reason ? 'selected' : old('reason')  }} >{{$leave_reason->reason}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                        @if ($errors->has('reason'))
                                                            <span class="invalid-feedback" role="alert" >
                                                            <span class="messages"><strong>{{ $errors->first('reason') }}</strong></span>
                                                        </span>
                                                        @endif

                                                        <div id="leave_reason">
                                                            <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description') }}" name="description"></textarea>
                                                            <p style="color: darkred">Maximum 350 characters</p>
                                                            @if ($errors->has('description'))
                                                                <span class="invalid-feedback" role="alert" >
                                                                <span class="messages"><strong>{{ $errors->first('description') }}</strong></span>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row col-md-12">
                                                    <div class="col-sm-12 text-center">
                                                        <button type="submit" class="btn btn-primary m-b-0">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{ Form::close()}}
                                </div>

                                <div class="card">
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        @if(isset($leave_types))
                                            @foreach($leave_types as $leave_type)
                                                <div class="col-md-2" align="center">
                                                    <h6>{{ $leave_type->leave_type }}</h6>
                                                    <p>Total days: {{ $leave_type->total_leaves }} </p>
                                                    <p>Used days:
                                                        @if(isset($leave_type->leave_count))
                                                            @foreach($leave_type->leave_count as $leave_count)
                                                                @if($leave_count->employee_id == $editData->id)
                                                                    {{ $leave_count->count }}
                                                                @endif
                                                            @endforeach
                                                        @else 0
                                                        @endif
                                                    </p>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="basic-btn" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>SL.</th>
                                            <th>Leave Type</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Total days</th>
                                            <th>Status</th>
                                            <th>Approver</th>
                                            <th>Applied On</th>
                                            <th>Details</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $i = 1 @endphp
                                        @foreach($leaves as $leave)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{ $leave->leave_type->leave_type }}</td>
                                                <td>{{date('d-M-Y', strtotime($leave->start_date))}}</td>
                                                <td>{{date('d-M-Y', strtotime($leave->end_date))}}</td>
                                                <td>{{ $leave->total_days }}</td>
                                                <td>
                                                    @if($leave->approval_status == 0)
                                                        <button type="button" class="btn btn-warning btn-sm">Pending</button>
                                                    @elseif($leave->approval_status == 1)
                                                        <button type="button" class="btn btn-success btn-sm">Approved</button>
                                                    @elseif($leave->approval_status == 2)
                                                        <button type="button" class="btn btn-danger btn-sm">Cancelled</button>
                                                    @endif
                                                </td>
                                                <td>
                                                    @foreach($users as $approver)
                                                        @if( $leave->approved_by == $approver->id )
                                                            {{$approver->name}}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>{{date('d-M-Y', strtotime($leave->created_at))}}</td>
                                                <td>
                                                    <a href="#myModal" data-toggle="modal" data-target="#myModal_{{ $leave->id}}" data-id="{{$leave->id}}" >
                                                        <i class="ti-arrow-circle-right" style="font-size: 1.5em; color: #11c15b;"></i>
                                                    </a>

                                                    <!-- Leave Details Model -->
                                                    <div class="modal fade" id="myModal_{{ $leave->id}}" role="dialog" >
                                                        <div class="modal-dialog modal-lg">

                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    @if( isset($editData->first_name) || isset($editData->last_name))
                                                                        <h4 class="modal-title" style="color:#000000">{{ $editData->first_name .' '. $editData->last_name }}</h4>
                                                                    @endif
                                                                </div>
                                                                <div class="modal-body" >
                                                                    <div class="table-responsive">
                                                                        <table class="table m-0">
                                                                            <tbody>
                                                                            <tr>
                                                                                <th scope="col">Leave Type</th>
                                                                                <td>{{ $leave->leave_type->leave_type }}</td>

                                                                                <th scope="row">Applied On</th>
                                                                                <td>{{ date('d-M-Y', strtotime($leave->created_at)) }}</td>
                                                                            </tr>

                                                                            <tr>
                                                                                <th scope="row">Start Date</th>
                                                                                <td>{{ date('d-M-Y', strtotime($leave->start_date)) }}</td>

                                                                                <th scope="row">End Date</th>
                                                                                <td>{{ date('d-M-Y', strtotime($leave->end_date)) }}</td>
                                                                            </tr>

                                                                            <tr>
                                                                                <th scope="row">Approver Name</th>
                                                                                @foreach($users as $approver)
                                                                                    @if( $leave->approved_by == $approver->id )
                                                                                        <td>{{ $approver->name }}</td>
                                                                                    @endif
                                                                                @endforeach

                                                                                <th scope="row">Approval Status</th>
                                                                                @if( $leave->approval_status==0 )
                                                                                    <td style="color: #FFD700;">Pending</td>
                                                                                @elseif( $leave->approval_status==1 )
                                                                                    <td style="color: #2eb82e;">Approved</td>
                                                                                @elseif( $leave->approval_status==2 )
                                                                                    <td style="color: red;">Cancelled</td>
                                                                                @endif
                                                                            </tr>

                                                                            <tr>
                                                                                <th scope="row">Reason</th>
                                                                                <td colspan="3">{{ $leave->description }}</td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row ">
                                                                    <div class="col-sm-12 text-center">
                                                                        @if(Auth::user()->id == $leave->approved_by && $leave->approval_status == 0)

                                                                            {{ Form::open(['class' => '', 'files' => true, 'url' => 'employee/leavePermission/'.$leave->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                                                            <button type="submit" class="btn btn-success m-b-0" name="permission" value="approve">Approve</button>
                                                                            <button type="submit" class="btn btn-primary m-b-0" name="permission" value="cancel">Cancel</button>
                                                                            {{ Form::close()}}

                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="attendance_history" role="tabpanel">
                        <div class="row logo" id="logo" style="display:none;">
                            <div class="col-md-4" style="padding:3% 0 3% 5%;">
                                <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}" height="10" width="120">
                            </div>
                            <div class="col-md-4" style="text-align: center; margin-top: 25px; font-weight: bold; padding:3% 0 3% 5%;">
                                <p style="font-size: 26px; ">Attendance of {{ $editData->first_name }} {{ $editData->last_name }}</p>
                                <p style="font-size: 22px; ">For the month of {{ $month }}</p>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-header-text">Attendance History of {{ $month }}</h5>
{{--                                <a class="btn btn-success printBtn" onclick="printAttendanceDiv('attendance_history')" id="attendance_print" style="float: right; padding: 6px 10px;" target="_blank">Print Attendance</a>--}}
                            </div>
                            <div class="card-block">
                                @if( Auth::user()->getRoleNames()->first() == 'Super Admin' || Auth::user()->getRoleNames()->first() == 'HR Admin')
                                    {{ Form::open(['class' => '', 'files' => true, 'url' => 'employee/attendance/'.$editData->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                    {{csrf_field()}}
                                    <div class="card printBtn">
                                        <div class="card-block">
                                            <h6 style="color: blue;"> MANUAL ATTENDANCE </h6>
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <div class="form-group col-md-4">
                                                        <label for="attendance_date"><strong> Date:</strong></label>
                                                        <input type="" class="form-control datepicker {{ $errors->has('attendance_date') ? ' is-invalid' : '' }}" value="{{ old('attendance_date') }}" name="attendance_date" required/>
                                                        @if ($errors->has('attendance_date'))
                                                            <span class="invalid-feedback" role="alert">
                                                    <span class="messages"><strong>{{ $errors->first('attendance_date') }}</strong></span>
                                                </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <label for="in_time"><strong>IN Time:</strong></label>
                                                        <input type="time" class="form-control {{ $errors->has('in_time') ? ' is-invalid' : '' }}" value="{{ old('in_time') }}" name="in_time" required/>
                                                        @if ($errors->has('in_time'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <span class="messages"><strong>{{ $errors->first('in_time') }}</strong></span>
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group col-md-3">
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
                                            <th>IN Time</th>
                                            <th>OUT Time</th>
                                            <th>Overtime</th>
                                            <th>Total Hours</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $i = 1 @endphp
                                        @if(isset($attendances))
                                            @foreach($attendances as $attendance)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{date('d-M-Y', strtotime($attendance->attendance_date))}}</td>
                                                    <td>{{date('h:i A', strtotime($attendance->in_time))}}</td>
                                                    <td>{{date('h:i A', strtotime($attendance->out_time))}}</td>
                                                    @if(isset($attendance->overtime))
                                                        <td>{{date('H:i ', strtotime($attendance->overtime))}} hours</td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                    <td>{{date('H:i', strtotime($attendance->total_hours))}} hours</td>
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

                    <div class="tab-pane" id="task" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-header-text">Tasks</h5>
                            </div>
                            <div class="card-block">
                                <div class="table-responsive">
                                    <table id="print-row" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>SL.</th>
                                            <th>Project Name</th>
                                            <th>Task Name</th>
                                            <th>Priority</th>
                                            <th>Due Date</th>
                                            <th>Status</th>
                                            <th>Assigned By</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $i = 1 @endphp
                                        @foreach($editData->tasks as $task)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>
                                                    {{ $task->project->project_name }}
                                                </td>
                                                <td>{{ $task->task_name }}</td>
                                                <td>
                                                    @if($task->priority == 0)
                                                        <button type="button" class="btn btn-warning btn-sm">Medium</button>
                                                    @elseif($task->priority == 1)
                                                        <button type="button" class="btn btn-success btn-sm">High</button>
                                                    @elseif($task->priority == 2)
                                                        <button type="button" class="btn btn-danger btn-sm">Urgent</button>
                                                    @endif
                                                </td>
                                                <td>{{ date('d-M-Y', strtotime($task->due_date)) }}</td>
                                                @if($task->task_status == 'reassigned')
                                                    <td style="color: red;">
                                                @else
                                                    <td style="color: blue;">
                                                        @endif
                                                        {{ ucwords($task->task_status) }}
                                                    </td>
                                                    <td>
                                                        @foreach( $users as $user )
                                                            @if( $task->assigned_by == $user->id)
                                                                {{ $user->name }}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('task.show',$task->id) }}" title="View"><button type="button" class="btn btn-basic action-icon"><i class="fa fa-eye"></i></button></a>

                                                        @if( Auth::user()->employee_id == $editData->id )
                                                            <a class="modalLink" title="Completed" data-modal-size="modal-md" href="{{url('submitTaskView',$task->id)}}"><button type="button" class="btn btn-success action-icon"><i class="fa fa-check"></i></button></a>
                                                        @endif

                                                        @if(Auth::user()->id == $task->assigned_by && $task->task_status == 'waiting')
                                                            <a class="modalLink" title="Completed" data-modal-size="modal-md" href="{{url('confirmTaskView',$task->id)}}"><button type="button" class="btn btn-success action-icon"><i class="fa fa-check"></i></button></a>
                                                            <a class="modalLink" title="Re-Assign" data-modal-size="modal-md" href="{{url('reassignTaskView',$task->id)}}"><button type="button" class="btn btn-danger action-icon"><i class="fa fa-times"></i></button></a>
                                                        @endif
                                                    </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-header-text">Projects Involved In</h5>
                            </div>
                            <div class="card-block">
                                <div class="table-responsive">
                                    <table id="project_table" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>SL.</th>
                                            <th>Project ID</th>
                                            <th>Project Name</th>
                                            <th>Status</th>
                                            <th>Contract Type</th>
                                            <th>Assigned By</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $i = 1 @endphp
                                        @foreach($projects_involved as $project)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{ $project->project->project_code }}-{{ $project->project->project_phase }}</td>
                                                <td>{{ $project->project->project_name }}</td>
                                                <td>{{ ucwords($project->project->project_status) }}</td>
                                                <td>
                                                    @if($project->project->contract_type == 3) Local
                                                    @elseif($project->project->contract_type == 2) Subconsultant
                                                    @elseif($project->project->contract_type == 1) Joint Venture
                                                    @endif
                                                </td>
                                                <td>
                                                    @foreach( $users as $user )
                                                        @if( $project->created_by == $user->id)
                                                            {{ $user->name }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <a href="{{ route('project.show',$project->project_id) }}" title="View"><button type="button" class="btn btn-basic action-icon"><i class="fa fa-eye"></i></button></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="materials" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-header-text">Materials</h5>
                            </div>
                            <div class="card-block">
                                @if(Auth::user()->employee_id == $editData->id && (Auth::user()->getRoleNames()->first() == 'Super Admin' || Auth::user()->getRoleNames()->first() == 'HR Admin' || Auth::user()->getRoleNames()->first() == 'Inventory Admin' || Auth::user()->getRoleNames()->first() == 'PM Admin'))
                                    <div class="card">
                                        <div class="card-block">
                                            {{ Form::open(['class' => '', 'files' => true, 'url' => 'employeeIndent', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                            {{csrf_field()}}
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <div class="form-group col-md-5">
                                                        <label for="product"><strong> Product Name:</strong></label>
                                                        <select class="js-example-basic-single col-sm-12 {{ $errors->has('product') ? ' is-invalid' : '' }}" name="product" id="product">
                                                            <option value="">Select Product</option>
                                                            @if(isset($products))
                                                                @foreach($products as $product)
                                                                    <option value="{{ $product->product }}"  {{ old('product')== $product->product ? 'selected' : ''  }}>{{ $product->product }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-md-5">
                                                        <label for="employee_id"><strong> Employee:</strong></label>
                                                        <select class="js-example-basic-single col-sm-12 {{ $errors->has('employee_id') ? ' is-invalid' : '' }}" name="employee_id" id="employee_id">
                                                            <option value="">Select Employee</option>
                                                            @if(isset($employees))
                                                                @foreach($employees as $employee)
                                                                    <option value="{{ $employee->id }}" {{ old('employee_id')== $employee->id ? 'selected' : ''  }}>{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-md-2">
                                                        <label for="quantity"><strong>Quantity:</strong></label>
                                                        <input type="number" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}" value="{{ old('quantity') ? old('quantity') : 1 }}" name="quantity" required />
                                                        @if ($errors->has('quantity'))
                                                            <span class="invalid-feedback" role="alert">
                                                            <span class="messages"><strong>{{ $errors->first('quantity') }}</strong></span>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row col-md-12">
                                                    <div class="form-group col-md-10">
                                                        <label for="description"><strong>Description:</strong></label>
                                                        <input type="text" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description') }}" name="description" required />
                                                        @if ($errors->has('description'))
                                                            <span class="invalid-feedback" role="alert">
                                                            <span class="messages"><strong>{{ $errors->first('description') }}</strong></span>
                                                        </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group col-md-2" style="align-content: center">
                                                        <label for="submit"></label>
                                                        <input type="submit" class="form-control btn btn-primary m-b-0" style="margin-top: 5px;" />
                                                    </div>
                                                </div>
                                            </div>
                                            {{ Form::close()}}
                                        </div>
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table id="material_table" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>SL.</th>
                                            <th>Asset Number</th>
                                            <th>Product Name</th>
                                            <th>Serial Number</th>
{{--                                            <th>Indent No</th>--}}
                                            <th>Assigned On</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $i = 1 @endphp
                                        @foreach($editData->materials as $material)
                                            @if($material->quantity > 0)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td style="text-align: left">
                                                        @if(isset($material->inventory->coa_reference_no))
                                                            <a href="{{ url('single_account', $material->inventory->coa_id) }}" target="_blank">{{ $material->inventory->coa_reference_no }}</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($material->inventory_id)
                                                            {{ $material->inventory->product->product }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($material->inventory)
                                                            {{ $material->inventory->serial_no }}
                                                        @endif
                                                    </td>
{{--                                                    <td>{{ $material->indent_no }}</td>--}}
                                                    <td>{{ date('d-M-Y', strtotime($material->created_at)) }}</td>
                                                    <td>
                                                        @if($material->inventory)
                                                            <a href="#myModal" data-toggle="modal" data-target="#myModal_{{ $material->id}}" data-id="{{$material->id}}" >
                                                                <button type="button" class="btn btn-basic action-icon"><i class="fa fa-eye"></i></button>
                                                            </a>
                                                            <!-- Product Details Model -->
                                                            <div class="modal fade" id="myModal_{{ $material->id}}" role="dialog" >
                                                                <div class="modal-dialog modal-lg">

                                                                    <!-- Modal content-->
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            @if( isset($material->inventory_id) )
                                                                                <h4 class="modal-title" style="color:#000000">{{ $material->inventory->product->product }}</h4>
                                                                            @endif
                                                                        </div>
                                                                        <div class="modal-body" >
                                                                            <div class="table-responsive">
                                                                                <table class="table m-0">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <th scope="col">Product </th>
                                                                                        <td>
                                                                                            @if($material->inventory)
                                                                                                {{ $material->inventory->product->product }}
                                                                                            @endif
                                                                                        </td>

                                                                                        @if(isset($material->driver_id))
                                                                                            <th scope="col">Driver</th>
                                                                                            <td>{{ $material->driver->first_name }} {{ $material->driver->last_name }}</td>
                                                                                        @else
                                                                                            <td colspan="2"></td>
                                                                                        @endif
                                                                                    </tr>

                                                                                    <tr>
                                                                                        <th scope="row">Serial No</th>
                                                                                        <td>
                                                                                            @if($material->inventory)
                                                                                                {{ $material->inventory->serial_no }}
                                                                                            @endif
                                                                                        </td>

                                                                                        <th scope="row">Brand Name</th>
                                                                                        <td>{{ $material->inventory->brand_name }}</td>
                                                                                    </tr>

                                                                                    @if($material->inventory->type==1)
                                                                                        <tr>
                                                                                            <th scope="row">COA Reference No</th>
                                                                                            <td>{{$material->inventory->coa_reference_no}}</td>

                                                                                            <th scope="row">Depreciation Rate</th>
                                                                                            <td>{{ $material->inventory->depreciation_rate }}%</td>
                                                                                        </tr>
                                                                                    @endif
                                                                                    <tr>
                                                                                        <th scope="row">Location</th>
                                                                                        <td>{{ $material->inventory->location == 1 ? 'Head Office' : '' }}</td>

                                                                                        <th scope="row">Purchase Date</th>
                                                                                        <td>{{ isset($material->inventory->purchase_date) ? $material->inventory->purchase_date : '' }}</td>
                                                                                    </tr>

                                                                                    <tr>
                                                                                        <th scope="row">Price (per product)</th>
                                                                                        <td>Tk {{ $material->inventory->price }}</td>

                                                                                        <th scope="row">Payment Method</th>
                                                                                        <td>
                                                                                            @if($material->inventory->payment_method==0)
                                                                                                By Cash
                                                                                            @elseif($material->inventory->payment_method==1)
                                                                                                By Cheque
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>

                                                                                    <tr>
                                                                                        <th scope="row">Vendor Name</th>
                                                                                        <td>
                                                                                            @if(isset($material->inventory->vendor_id))
                                                                                                {{ $material->inventory->vendor->vendor_name }}
                                                                                            @endif
                                                                                        </td>

                                                                                        <th scope="row">Vendor Contact</th>
                                                                                        <td>
                                                                                            @if(isset($material->inventory->vendor_id))
                                                                                                {{ $material->inventory->vendor->phone_number }}
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>

                                                                                    <tr>
                                                                                        <th scope="row">Added By</th>
                                                                                        @foreach($users as $user)
                                                                                            @if( $material->inventory->created_by == $user->id )
                                                                                                <td>{{ $user->name }}</td>
                                                                                            @endif
                                                                                        @endforeach

                                                                                        <th scope="row">Added At</th>
                                                                                        <td>{{ date('d-M-Y', strtotime($material->inventory->created_at)) }}</td>
                                                                                    </tr>

                                                                                    <tr>
                                                                                        <th scope="row">Description</th>
                                                                                        <td colspan="3">{{ $material->inventory->description }}</td>
                                                                                    </tr>
                                                                                    @if(isset($material->inventory->upload_document))
                                                                                        <tr>
                                                                                            <th scope="row">Voucher</th>
                                                                                            <td colspan="3">
                                                                                                <a href="{{url('inventory/document/'.$material->inventory->id)}}" target="_blank"><button type="button" class="btn btn-sm" style="background-color: lightgrey; font-size: 1.05em;">Read File</button>
                                                                                                </a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endif
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @can('Assign Inventory')
                                                                <a class="modalLink" title="Return" data-modal-size="modal-md" href="{{url('assignBackView', $material->inventory_id)}}">
                                                                    <button type="button" class="btn btn-danger action-icon"><i class="fa fa-arrow-left"></i></button>
                                                                </a>
{{--                                                                <a href="#assignModal" data-toggle="modal" data-target="#assignModal_{{ $material->id}}" data-id="{{$material->id}}" >--}}
{{--                                                                    <button type="button" class="btn btn-success action-icon">Assign </button>--}}
{{--                                                                </a>--}}
                                                        @endcan
                                                        <div class="modal fade" id="assignModal_{{ $material->id}}" role="dialog" >
                                                            <div class="modal-dialog modal-lg">

                                                                <!-- Modal content-->
                                                                <div class="modal-content form-group col-md-12">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" style="color:#000000">{{$material->inventory->product->product}}</h4>
                                                                    </div>
                                                                    <div class="modal-body" >
                                                                        {{ Form::open(['class' => '', 'files' => true, 'url' => 'employee/assign_material/'.$material->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                                                        <div class="form-group col-md-10">
                                                                            <label for="employee_id"> Assign To Employee</label><br>
                                                                            <select class="js-example-basic-single {{ $errors->has('employee_id') ? ' is-invalid' : '' }}" name="employee_id" id="employee_id">
                                                                                <option value="">Select Employee </option>
                                                                                <option value="inventory">Back to inventory</option>
                                                                                @foreach($employees as $employee)
                                                                                    <option value="{{ $employee->id }}"  {{ old('employee_id')== $employee->id ? 'selected' : ''  }}>{{$employee->first_name}} {{$employee->last_name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            @if ($errors->has('employee_id'))
                                                                                <span class="invalid-feedback" role="alert" >
                                                                                <span class="messages"><strong>{{ $errors->first('employee_id') }}</strong></span>
                                                                            </span>
                                                                            @endif
                                                                        </div>

                                                                        <div class="form-group col-md-10">
                                                                            <label for="quantity"> Quantity  </label>
                                                                            <input type="number" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}" value="{{ old('quantity') ? old('quantity') : 1 }}" name="quantity"/>
                                                                            @if ($errors->has('quantity'))
                                                                                <span class="invalid-feedback" role="alert" >
                                                                                <span class="messages"><strong>{{ $errors->first('quantity') }}</strong></span>
                                                                            </span>
                                                                            @endif
                                                                        </div>

                                                                        <div class="form-group col-md-2">
                                                                            <label for="submit"></label>
                                                                            <input type="submit" class="form-control btn btn-primary m-b-0" style="margin-top: 5px;" />
                                                                        </div>
                                                                        {{ Form::close()}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        @foreach($editData->cars as $material)
                                            @if($material->quantity > 0)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td style="text-align: left">
                                                        @if(isset($material->coa_id))
                                                            <a href="{{ url('single_account', $material->coa_id) }}" target="_blank">{{ $material->coa->coa_reference_no }}</a>
                                                        @endif
                                                    </td>
                                                    <td>{{ $material->inventory->product->product }}</td>
                                                    <td>{{ $material->inventory->serial_no }}</td>
                                                    <td>{{ $material->indent_no }}</td>
                                                    <td>{{ date('d-M-Y', strtotime($material->created_at)) }}</td>
                                                    <td>
                                                        <a href="#myModal" data-toggle="modal" data-target="#myModal_{{ $material->id}}" data-id="{{$material->id}}" >
                                                            <button type="button" class="btn btn-basic action-icon"><i class="fa fa-eye"></i></button>
                                                        </a>
                                                        <!-- Product Details Model -->
                                                        <div class="modal fade" id="myModal_{{ $material->id}}" role="dialog" >
                                                            <div class="modal-dialog modal-lg">

                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        @if( isset($material->inventory_id) )
                                                                            <h4 class="modal-title" style="color:#000000">{{ $material->inventory->product->product }}</h4>
                                                                        @endif
                                                                    </div>
                                                                    <div class="modal-body" >
                                                                        <div class="table-responsive">
                                                                            <table class="table m-0">
                                                                                <tbody>
                                                                                <tr>
                                                                                    <th scope="col">Product </th>
                                                                                    <td>{{ $material->inventory->product->product }}</td>

                                                                                    <th scope="col">Assigned To</th>
                                                                                    <td>{{ $material->employee->first_name }} {{ $material->employee->last_name }}</td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <th scope="row">Serial No</th>
                                                                                    <td>{{ $material->inventory->serial_no }}</td>

                                                                                    <th scope="row">Brand Name</th>
                                                                                    <td>{{ $material->inventory->brand_name }}</td>
                                                                                </tr>

                                                                                @if($material->inventory->type==1)
                                                                                    <tr>
                                                                                        <th scope="row">COA Reference No</th>
                                                                                        <td>{{$material->inventory->coa_reference_no}}</td>

                                                                                        <th scope="row">Depreciation Rate</th>
                                                                                        <td>{{ $material->inventory->depreciation_rate }}%</td>
                                                                                    </tr>
                                                                                @endif
                                                                                <tr>
                                                                                    <th scope="row">Location</th>
                                                                                    <td>{{ $material->inventory->location }}</td>

                                                                                    <th scope="row">Purchase Date</th>
                                                                                    <td>{{ isset($material->inventory->purchase_date) ? $material->inventory->purchase_date : '' }}</td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <th scope="row">Quantity</th>
                                                                                    <td>{{ $material->inventory->quantity }}</td>

                                                                                    <th scope="row">Price (per product)</th>
                                                                                    <td>Tk {{ $material->inventory->price }}</td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <th scope="row">Vendor Name</th>
                                                                                    <td>{{ $material->inventory->vendor_name }}</td>

                                                                                    <th scope="row">Vendor Contact</th>
                                                                                    <td>{{ $material->inventory->vendor_contact }}</td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <th scope="row">Payment Method</th>
                                                                                    <td>
                                                                                        @if($material->inventory->payment_method==0)
                                                                                            By Cash
                                                                                        @elseif($material->inventory->payment_method==1)
                                                                                            By Cheque
                                                                                        @endif
                                                                                    </td>

                                                                                    <th scope="row">Re-ordering notice</th>
                                                                                    <td>{{ $material->inventory->min_amount }}</td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <th scope="row">Added By</th>
                                                                                    @foreach($users as $user)
                                                                                        @if( $material->inventory->created_by == $user->id )
                                                                                            <td>{{ $user->name }}</td>
                                                                                        @endif
                                                                                    @endforeach

                                                                                    <th scope="row">Added At</th>
                                                                                    <td>{{ date('d-M-Y', strtotime($material->inventory->created_at)) }}</td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <th scope="row">Description</th>
                                                                                    <td colspan="3">{{ $material->inventory->description }}</td>
                                                                                </tr>
                                                                                @if(isset($material->inventory->upload_document))
                                                                                    <tr>
                                                                                        <th scope="row">Voucher</th>
                                                                                        <td colspan="3">
                                                                                            <a href="{{url('inventory/document/'.$material->inventory->id)}}" target="_blank"><button type="button" class="btn btn-sm" style="background-color: lightgrey; font-size: 1.05em;">Read File</button>
                                                                                            </a>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @can('Assign Inventory')
                                                            <a href="#assignModal" data-toggle="modal" data-target="#assignModal_{{ $material->id}}" data-id="{{$material->id}}" >
                                                                <button type="button" class="btn btn-success action-icon">Assign </button>
                                                            </a>
                                                        @endcan
                                                        <div class="modal fade" id="assignModal_{{ $material->id}}" role="dialog" >
                                                            <div class="modal-dialog modal-lg">

                                                                <!-- Modal content-->
                                                                <div class="modal-content form-group col-md-12">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" style="color:#000000">{{$material->inventory->product->product}}</h4>
                                                                    </div>
                                                                    <div class="modal-body" >
                                                                        {{ Form::open(['class' => '', 'files' => true, 'url' => 'employee/assign_material/'.$material->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                                                        <div class="form-group col-md-10">
                                                                            <label for="employee_id"> Assign To Employee</label><br>
                                                                            <select class="js-example-basic-single {{ $errors->has('employee_id') ? ' is-invalid' : '' }}" name="employee_id" id="employee_id">
                                                                                <option value="">Select Employee </option>
                                                                                <option value="inventory">Back to inventory</option>
                                                                                @foreach($employees as $employee)
                                                                                    <option value="{{ $employee->id }}"  {{ old('employee_id')== $employee->id ? 'selected' : ''  }}>{{$employee->first_name}} {{$employee->last_name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            @if ($errors->has('employee_id'))
                                                                                <span class="invalid-feedback" role="alert" >
                                                                                <span class="messages"><strong>{{ $errors->first('employee_id') }}</strong></span>
                                                                            </span>
                                                                            @endif
                                                                        </div>

                                                                        <div class="form-group col-md-10">
                                                                            <label for="quantity"> Quantity  </label>
                                                                            <input type="number" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}" value="{{ old('quantity') ? old('quantity') : 1 }}" name="quantity"/>
                                                                            @if ($errors->has('quantity'))
                                                                                <span class="invalid-feedback" role="alert" >
                                                                                <span class="messages"><strong>{{ $errors->first('quantity') }}</strong></span>
                                                                            </span>
                                                                            @endif
                                                                        </div>

                                                                        <div class="form-group col-md-2">
                                                                            <label for="submit"></label>
                                                                            <input type="submit" class="form-control btn btn-primary m-b-0" style="margin-top: 5px;" />
                                                                        </div>
                                                                        {{ Form::close()}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="document" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-header-text">Documents</h5>
                                @if( Auth::user()->employee_id == $editData->id || Auth::user()->getRoleNames()->first() == 'Super Admin' || Auth::user()->getRoleNames()->first() == 'Admin' || Auth::user()->getRoleNames()->first() == 'HR Admin')
                                    <a href="#upload_document" class="btn btn-success collapsible" data-toggle="collapse" style="float: right; padding: 8px; color: white;">Upload Document</a>
                                @endif
                            </div>
                            <div class="card-block">
                                <div class="collapse" id="upload_document">
                                    {{ Form::open(['class' => '', 'files' => true, 'url' => 'employee/uploadDocument/'.$editData->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                    {{csrf_field()}}
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-8">
                                                <div class="form-group row col-md-12">
                                                    <div class="form-group col-md-6">
                                                        <label for="document_name">Document Name:</label>
                                                        <input type="text" class="form-control {{ $errors->has('document_name') ? ' is-invalid' : '' }}" value="{{ old('document_name') }}" name="document_name" required />
                                                        <p style="color: darkred">Maximum 100 characters</p>
                                                        @if ($errors->has('document_name'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <span class="messages"><strong>{{ $errors->first('document_name') }}</strong></span>
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="upload_document">Upload Document</label>
                                                        <input class="form-control" type="file" name="upload_document" id="upload_document" required>
                                                        <p style="color: darkred">Only .pdf, .jpg, .jpeg, .png files allowed</p>
                                                        @if ($errors->has('upload_document'))
                                                            <span class="invalid-feedback" role="alert" >
                                                                <span class="messages"><strong>{{ $errors->first('upload_document') }}</strong></span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row col-md-12">
                                                    <div class="form-group col-md-12">
                                                        <label for="description">Description</label>
                                                        <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description') }}" name="description" ></textarea>
                                                        @if ($errors->has('description'))
                                                            <span class="invalid-feedback" role="alert" >
                                                        <span class="messages"><strong>{{ $errors->first('description') }}</strong></span>
                                                    </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row col-md-12">
                                                    <div class="col-sm-12 text-center">
                                                        <button type="submit" class="btn btn-primary m-b-0">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{ Form::close()}}
                                </div>

                                <div class="table-responsive">
                                    <table id="print-btn" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>SL.</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>View File</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $i = 1 @endphp

                                        <!-- SHOW ALL DOCUMENTS UPLOADED -->
                                        @foreach($documents as $document)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{ $document->document_name }}</td>
                                                <td>{{ $document->description }}
                                                </td>
                                                <td><a href="{{url('employee/document/'.$document->id)}}" target="_blank"><button type="button" class="btn btn-sm" style="background-color: lightgrey; border: 1px solid black; font-size: 1.05em;">Read File</button></a>
                                                </td>
                                            </tr>
                                        @endforeach

                                        <!-- ALL EDUCATION QUALIFICATION DOCUMENTS -->
                                        @if(isset($editData->educations))
                                            @foreach($editData->educations as $education)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>Education</td>
                                                    <td>Education Qualifications Document</td>
                                                    <td><a href="{{url('employee/education/'.$education->id)}}" target="_blank"><button type="button" class="btn btn-sm" style="background-color: lightgrey;  border: 1px solid black; font-size: 1.05em;">Read File</button></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif

                                        <!-- ALL WORK EXPERINCE DOCUMENTS -->
                                        @foreach($experiences as $experience)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>Experience</td>
                                                <td>Work Experiences Document</td>
                                                <td><a href="{{url('employee/experience/'.$experience->id)}}" target="_blank"><button type="button" class="btn btn-sm" style="background-color: lightgrey;  border: 1px solid black; font-size: 1.05em;">Read File</button></a>
                                                </td>
                                            </tr>
                                        @endforeach

                                        @if( isset($editData->joining_letter) )
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>Joining Letter</td>
                                                <td>-</td>
                                                <td><a href="{{url('employee/joining_letter/'.$editData->id)}}" target="_blank"><button type="button" class="btn btn-sm" style="background-color: lightgrey;  border: 1px solid black; font-size: 1.05em;">Read File</button></a>
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endSection

@section('javascript')
    <script>
        window.onload = function() {
            var type = document.getElementById('type_of_leave');
            var casual = document.getElementById('casual_reason');
            casual.style.visibility = 'hidden';
            var reason = document.getElementById('leave_reason');
            // reason.style.visibility = 'hidden';
            type.onchange = function () {
                if (type.options[type.selectedIndex].value == 1) {
                    casual.style.visibility = 'visible';
                    reason.style.visibility = 'hidden';
                } else {
                    reason.style.visibility = 'visible';
                    casual.style.visibility = 'hidden';
                }
            }
        }
        $(document).ready(function() {
            $('#project_table').DataTable();
            $('#material_table').DataTable();
        } );
        function printSalaryDiv(employee_salary)
        {
            $('.logo').show();
            $('.footer').show();
            $('.printBtn').hide();
            $('#head').hide();
            $('#deductives').hide();
            var dt = new Date();
            document.getElementById("datetime").innerHTML = dt.toLocaleString();

            var printContents = document.getElementById(employee_salary).innerHTML;
            var unique_id = document.getElementById('unique_id').value;
            var month = document.getElementById('month').value;
            var employee_id = document.getElementById('employee_id').value;
            document.body.innerHTML = printContents;
            document.title=unique_id + ' Salary For ' + month;
            window.print();
            window.location.href = "/epc/employee/"+employee_id;
        }

        function printAttendanceDiv(attendance_history)
        {
            $('.logo').show();
            $('.footer').show();
            $('.printBtn').hide();
            var dt = new Date();
            document.getElementById("datetime1").innerHTML = dt.toLocaleString();

            var printContents = document.getElementById(attendance_history).innerHTML;
            var unique_id = document.getElementById('unique_id').value;
            var month = document.getElementById('month').value;
            var employee_id = document.getElementById('employee_id').value;
            document.body.innerHTML = printContents;
            document.title=unique_id + ' Attendance For ' + month;
            window.print();
            window.location.href = "/epc/employee/"+employee_id;
        }
    </script>
@endsection
