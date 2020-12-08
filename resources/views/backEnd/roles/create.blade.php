@extends('backEnd.master')
@section('mainContent')
    <div class="row">
        <div class="col-md-4">
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
              @can('Add/Edit Role')
            <div class="card">
                <div class="card-header">
                    <h5>Add New Role</h5>
                </div>
                <div class="card-block">
                    {{ Form::open(['class' => '', 'files' => true, 'url' => 'role',
                    'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label"><span class="important">*</span> Role Name</label>
                                <input type="text" class="form-control {{ $errors->has('role_name') ? ' is-invalid' : '' }}" name="role_name" id="name" placeholder="Add new role" value="{{old('role_name')}}" autocomplete="off">

                                @if ($errors->has('role_name'))
                                    <span class="invalid-feedback" role="alert">
									<span class="messages"><strong>{{ $errors->first('role_name') }}</strong></span>
								</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mt-4">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-primary m-b-0">Submit</button>
                        </div>
                    </div>
                    {{ Form::close()}}
                </div>
            </div>
                @endcan
        </div>
        <div class="col-md-8">
            @if(session()->has('message-success-assign-role'))
                <div class="alert alert-success mb-3 background-success" role="alert">
                    {{ session()->get('message-success-assign-role') }}
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
            <div class="card">
                <div class="card-header">
                    <h5>Roles</h5>
                </div>
                <div class="card-block">
                    <div class="dt-responsive table-responsive">
                        <table id="basic-btn" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Role Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($roles))
                                @php $i = 1 @endphp
                                @foreach($roles as $role)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$role->name}}</td>
                                        <td><button type="button" class="btn btn-success btn-sm">Active</button></td>
                                        <td>
{{--                                            <!-- <a href="" title="view"><button type="button" class="btn btn-success action-icon"><i class="fa fa-eye"></i></button></a> -->--}}
{{--                                            <!-- @can('Add/Edit Role') -->--}}
{{--                                            @if(Auth::user()->getRoleNames()->first() == 'Super Admin')--}}
                                            @if( $role->name != 'Super Admin')
                                                <a href="{{ url('role/'.$role->id.'/edit') }}" title="edit">
                                                    <button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button>
                                                </a>
{{--                                                <a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteRoleView', $role->id)}}">--}}
{{--                                                    <button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>--}}
{{--                                                </a>--}}
                                            @endif
{{--                                            <!-- @endcan -->--}}
                                            @can('Assign Permission by Role')
                                            <a href="{{url('role_assign-permission', $role->id)}}" title="view"><button type="button" class="btn btn-success action-icon">Assign Permission</button></a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endSection
