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


    <div class="card">
        <div class="card-header">
            <h5>Employee Lists</h5>
            @can('Add/Edit Employee')
                <a href="{{ route('employee.create') }}" style="float: right; padding: 8px; color: white;" class="btn btn-success">Add Employee </a>
            @endcan
        </div>
        @can('View Employee List')
            <div class="card-block">
                <div class="table-responsive">
                    <table id="basic-btn" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Photo</th>
                            <th>Employee ID</th>
                            <th>Full Name</th>
                            <th>Mobile</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i = 1 @endphp
                        @foreach($employees as $employee)
                            @if($employee->id != 1)
                                <tr  style="{{--{{ $employee->employee_status == 0 ? 'background-color:#ffc7c8; text-decoration: line-through' : '' }}--}};">
                                    <td>{{$i++}}</td>
                                    <td>
                                        <div class="d-inline-block align-middle">
                                            @if(empty($employee->employee_photo))
                                                <img src="{{asset('public/images/no_image.png')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                            @else
                                                <img src="{{asset($employee->employee_photo)}}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{$employee->unique_id}}</td>
                                    <td>{{$employee->first_name.' '.$employee->last_name}}</td>
                                    <td>{{$employee->mobile}}</td>
                                    <td>
                                        @if(isset($employee->department_id))
                                            {{$employee->department->department_name}}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($employee->designation_id))
                                            {{$employee->designation->designation_name}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($employee->employee_status == 1)
                                            <button type="button" class="btn btn-success btn-sm">Active</button>
                                        @else
                                            <button type="button" class="btn btn-danger btn-sm">In-active</button>
                                        @endif
                                    </td>
                                    <td>
                                        @canany(['View Employee Details','View Employee Salary','View Employee Leave','View Employee Attendance History','View Employee Tasks','View Employee Document'])
                                            <a href="{{ route('employee.show',$employee->id) }}" title="View"><button type="button" class="btn btn-basic action-icon"><i class="fa fa-eye"></i></button></a>
                                        @endcanany

                                        @can('Add/Edit Employee')
                                            <a href="{{ route('employee.edit',$employee->id) }}" title="Edit"><button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button></a>
                                        @endcan

                                        @if(Auth::user()->getRoleNames()->first() == 'Super Admin')
                                            <a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteEmployeeView', $employee->id)}}"><button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button></a>
                                        @endif

                                        @hasanyrole($roles)
                                        {{--                                    @can('Add as User')--}}
                                        <a href="{{ url('user/create',$employee->id) }}" title="Add User"><button type="button" class="btn btn-success action-icon"><i class="fa fa-plus"></i></button></a>
                                        {{--                                @endcan--}}
                                        @endhasanyrole
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <button class="btn btn-success" onclick="printDiv('employee_address')" style="padding: 8px; color: white;" target="_blank">Print Employees Addresses </button>
            </div>

            {{--    // FOR PRINTING ADDRESSES--}}

            <div id="employee_address" hidden>
                <div class="row" id="logo" style="display:none; margin-bottom: 30px;">
                    <div class="" style="padding:3% 0 3% 5%; float:left">
                        <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}" height="10" width="120">
                        <p style="margin-top: 15px; font-size: 14px; font-weight: bold;">Engineering & Planning Consultants Ltd</p>
                    </div>
                    <div class="" style="text-align: center; font-weight: bold; padding:3% 0 3% 0%;">
                        <p style="margin-top: 15px; font-size: 20px; ">Employees Address List</p>
                    </div>
                </div>
                <div class="card-block">
                    <br>
                    <div class="">
                        <table class="">
                            <tbody>
                            @php $i = 1 @endphp
                            @foreach($employees as $employee)
                                @if($employee->id != 1)
                                    <tr>
                                        <td>
                                            <table class="">
                                                <tr>
                                                    <th>Employee ID: </th>
                                                    <td>{{$employee->unique_id}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Name: </th>
                                                    <td>{{$employee->first_name.' '.$employee->last_name}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Designation: </th>
                                                    <td>
                                                        @if(isset($employee->designation_id))
                                                        {{$employee->designation->designation_name}}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Phone No: </th>
                                                    <td>{{$employee->mobile}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Address: </th>
                                                    <td>{{$employee->current_address}}</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>............................................................................................................</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="text-bottom text-center pt-5 mt-5" style="display: none" id="footer">
                    <div class="row">
                        <div class="col">
                            <p style="font-size: 0.9rem; background-color: #ece7e4;" >ERP Version 1.1 | Developed by: White Paper | Printed By: {{ Auth::user()->name }} | <span id="datetime"> </p>
                        </div>
                    </div>
                </div>
            </div>
        @endcan()
    </div>
@endSection

@section('javascript')
    <script>
        function printDiv(employee_address)
        {
            document.getElementById('logo').style.display = "block";
            document.getElementById('footer').style.display = "block";
            var dt = new Date();
            document.getElementById("datetime").innerHTML = dt.toLocaleString();

            var printContents = document.getElementById(employee_address).innerHTML;
            document.body.innerHTML = printContents;
            document.title='Employees Address List';
            window.print();
            window.location.href = "/epc/employee";
        }
    </script>
@endsection
