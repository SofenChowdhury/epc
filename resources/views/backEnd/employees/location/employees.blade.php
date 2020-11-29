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
            <h5>Employees in room {{ $room->room_no }}</h5>
            <a href="{{ url('location') }}" style="float: right; padding: 8px; color: white;" class="btn btn-success"> Room No List </a>
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
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i = 1 @endphp
                        @foreach($employees as $employee)
                            @if($employee->id != 1)
                                {{--                                @php $hourly_rate = ceil(App\ErpEmployeeSalary::hourly_calc($employee->id)); @endphp--}}
                                <tr>
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
                                        @canany(['View Employee Details','View Employee Salary','View Employee Leave','View Employee Attendance History','View Employee Tasks','View Employee Document'])
                                            <a href="{{ route('employee.show',$employee->id) }}" title="View"><button type="button" class="btn btn-basic action-icon"><i class="fa fa-eye"></i></button></a>
                                        @endcanany
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        @endcan()
    </div>
@endSection
