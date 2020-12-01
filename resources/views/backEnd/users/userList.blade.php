@extends('backEnd.master')
@section('mainContent')
    <div class="row">
        <div class="col-md-12">

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
            @if(session()->has('message-success-assign-user'))
                <div class="alert alert-success mb-3 background-success" role="alert">
                    {{ session()->get('message-success-assign-user') }}
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

           @canany(['View User List','Edit User','Delete User','Assign Permission by User'])
            <div class="card">
                <div class="card-header">
                    <h5>Users</h5>
                    @can('Delete User')
                        @if(!isset($suspend))
                            <a href="{{ url('suspended') }}" style="float: right; padding: 8px; color: white;" class="btn btn-success"> Inactive Users List </a>
                        @else
                            <a href="{{ url('user') }}" style="float: right; padding: 8px; color: white;" class="btn btn-success"> Active Users List </a>
                        @endif
                    @endcan
                </div>
                <div class="card-block">
                    <div class="dt-responsive table-responsive">
                        <table id="basic-btn" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Employee Id</th>
                                    <th>Email</th>
                                    <th>Last Login</th>
                                    <th>Last Login IP</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(isset($users))
                                @php $i = 1 @endphp
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>
                                            @foreach($user->roles as $roles)
                                                @if($roles)
                                                    {{$roles->name}}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{$user->employee->unique_id}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->last_login_at}}</td>
                                        <td>{{$user->last_login_ip}}</td>
                                        @if($user->active_status == 1)
                                            <td>
                                                <a href="{{ route('employee.show',$user->employee_id) }}" title="View">
                                                    <button type="button" class="btn btn-success action-icon"><i class="fa fa-eye"></i></button>
                                                </a>
                                                @can('Edit User')
                                                    @foreach($user->roles as $role)
                                                        @if($role->name != 'Super Admin')
                                                            <a href="{{ url('user/'.$user->id.'/edit') }}" title="Edit">
                                                                <button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button>
                                                            </a>
                                                        @endif
                                                    @endforeach

                                                @endcan
                                                @can('Delete User')
                                                    @if(Auth::user()->getRoleNames()->first() == 'Super Admin')
                                                        @if($role->name != 'Super Admin')
                                                        <a class="modalLink" title="Inactive User" data-modal-size="modal-md" href="{{url('deleteUserView', $user->id)}}">
                                                            <button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>
                                                        </a>
                                                        @endif
                                                    @endif
                                                @endcan
                                                @can('Assign Permission by User')
                                                <a href="{{url('user_assign-permission', $user->id)}}" title="view">
                                                    <button type="button" class="btn btn-success action-icon">Assign Permission </button>
                                                </a>
                                                @endcan
                                            </td>
                                        @else
                                            <td>
                                                @can('Delete User')
                                                <a class="modalLink" title="Activate" data-modal-size="modal-md"
                                                   href="{{url('activeUserView', $user->id)}}">
                                                    <button type="button" class="btn btn-success action-icon">Activate User</button>
                                                </a>
                                                @endcan
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endcanany
        </div>
    </div>

@endSection
