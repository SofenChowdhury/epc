<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        @if( isset($editData->first_name) || isset($editData->last_name))
            {{ $editData->first_name .' '. $editData->last_name .' '. $editData->unique_id}}
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
    <style>
        #logo {
            position: fixed;
            top: 0;
        }
    </style>
</head>

<body>
    <div class="card-block" id="page">

        <div class="row" id="logo">
            <div class="col-md-4" style="padding:3% 0 3% 5%;">
                <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}" height="10" width="120">
            </div>
            <div class="col-md-4" style="text-align: center; font-weight: bold; padding:3% 0 3% 5%;">
                <p style="margin-top: 25px; font-size: 26px; ">Employee Details of {{ $editData->first_name }} {{ $editData->last_name }}</p>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-8"></div>
            <div class="form-group col-md-3">
                @if( isset($editData->employee_photo) )
                    <img src="{{ asset($editData->employee_photo) }}" class="image_center img-radius" height="200px" width="200px" />
                @else
                    <img src="{{ asset('/public/images/no_image.png') }}" class="image_center img-radius" height="200px" width="200px" />
                @endif
            </div>
        </div>
        <div class="view-info">
            <div class="row">
                <div class="col-lg-12">
                    <div class="general-info">
                        <div class="row">
                            <div class="col-lg-12 ">
                                <div class="table-responsive">
                                    <table class="table m-0">
                                        <tbody>

                                            <!-- UNIQUE ID -->
                                            <tr>
                                                <th scope="col">Employee ID</th>
                                                @if( isset($editData->unique_id))
                                                    <td colspan="3">{{ $editData->unique_id }}</td>
                                                @else
                                                    <td colspan="3"></td>
                                                @endif
                                            </tr>

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
                                                <th scope="row">Previously worked in EPC? <br> If yes, then when?</th>
                                                @if( isset($editData->family->epc_before) )
                                                    @if($editData->family->epc_before == 1)
                                                        <td>Yes</td>
                                                        @if( isset($editData->family->epc_before_date) )
                                                            <th>Date</th>
                                                            <td>{{ date('d-M-Y', strtotime($editData->family->epc_before_date)) }}</td><td></td>
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
                                                    <td colspan="2">{{ $editData->family->relative_name }}</td>
                                                @else
                                                    <td colspan="2"></td>
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
                                                    <td>{{ $editData->family->child_name}}</td>
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
                                                <th scope="row">Bank Address</th>
                                                @if( isset($editData->bank->bank_address) )
                                                    <td>{{ $editData->bank->bank_address }}</td>
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
                                                    <td>@foreach($users as $user)
                                                        @if( $editData->created_by == $user->id )
                                                            {{$user->name}}
                                                        @endif
                                                    @endforeach</td>
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
