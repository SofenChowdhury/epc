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

		<div class="card">
			<div class="card-header">
				<h5>Add New User</h5>
			</div>
			<div class="card-block">
				{{ Form::open(['class' => '', 'files' => true, 'url' => 'user',
				'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
					<div class="row">
						<div class="col-md-12">
                            <input type="text" class="form-control{{ $errors->has('employee_id') ? ' is-invalid' : '' }}" hidden name="employee_id" id="employee_id" value="{{ $employee->id }}" >
                            <div class="form-group row">
                                <label for="unique_id" class="col-md-4 col-form-label text-md-right">{{ __('Employee ID') }}</label>
                                <div class="col-md-6">
                                    @if(isset($employee))
                                        <input type="text" class="form-control{{ $errors->has('unique_id') ? ' is-invalid' : '' }}" readonly name="unique_id" id="unique_id" value="{{ $employee->unique_id }}" >
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                <div class="col-md-6">
                                    @if(isset($employee))
                                        <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" readonly name="name" id="name" value="{{ $employee->first_name }} {{ $employee->last_name }}" >
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
				                <label for="email" class="col-md-4 col-form-label text-md-right"> <span class="important">*</span> {{ __('E-Mail Address') }}</label>
                                <div class="col-md-6">
				                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $employee->email ? $employee->email : '' }}" autocomplete="off">
                                    @if ($errors->has('email'))
				                        <span class="invalid-feedback" role="alert">
				                            <strong>{{ $errors->first('email') }}</strong>
				                        </span>
				                    @endif
				                </div>
				            </div>

				            <div class="form-group row">
				                <label for="role_id" class="col-md-4 col-form-label text-md-right"> <span class="important">*</span> {{ __('Role Name') }}</label>
				                <div class="col-md-6">
					                <select class="js-example-basic-single col-sm-12 {{ $errors->has('role_id') ? ' is-invalid' : '' }}" name="role_id" id="role_id">
									<option value="">Select Role </option>
									@if(isset($roles))
										@foreach($roles as $role)
											@if( $role->name != 'Super Admin' )
											<option value="{{ $role->id }}" {{ old('role_id')== $role->id ? 'selected' : ''  }} >{{$role->name}}</option>
											@endif
										@endforeach
									@endif
									</select>
									@if ($errors->has('role_id'))
									<span class="invalid-feedback invalid-select" role="alert">
										<strong>{{ $errors->first('role_id') }}</strong>
									</span>
									@endif
								</div>
				            </div>

				            <div class="form-group row">
				                <label for="password" class="col-md-4 col-form-label text-md-right"> <span class="important">*</span> {{ __('Password') }}</label>
                                <div class="col-md-6">
				                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
                                    <p class="form-group" style="color: red">Minimum 6 characters</p>
                                    @if ($errors->has('password'))
				                        <span class="invalid-feedback" role="alert">
				                            <strong>{{ $errors->first('password') }}</strong>
				                        </span>
				                    @endif
				                </div>
				            </div>


				            <div class="form-group row">
				                <label for="password-confirm" class="col-md-4 col-form-label text-md-right"> <span class="important">*</span> {{ __('Confirm Password') }}</label>
				                <div class="col-md-6">
				                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >
				                </div>
				            </div>
						</div>
					</div>
					<div class="form-group row mt-5">
						<div class="col-sm-6 text-center">
							<a class="" title="Back" href="{{url('/employee')}}">
								<button type="button" class="btn btn-primary m-b-0">Go Back</button>
							</a>
						</div>
						<div class="col-sm-5 text-center">
							<button type="submit" class="btn btn-primary m-b-0">Add user</button>
						</div>
					</div>
				{{ Form::close()}}
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">
				<h5>Users</h5>
			</div>
			<div class="card-block">
				<div class="dt-responsive table-responsive">
				<table id="basic-btn" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Sl No.</th>
                            <th>Employee Id</th>
                            <th>Name</th>
                            <th>Role</th>
							<th>Email</th>
						</tr>
					</thead>
					<tbody>
						@if(isset($users))
							@php $i = 1 @endphp
							@foreach($users as $user)
							<tr>
								<td>{{$i++}}</td>
                                <td>{{$user->employee->unique_id}}</td>
                                <td>{{$user->name}}</td>
								<td>
									@foreach($user->roles as $roles)
                                        @if($roles)
                                            {{$roles->name}}
                                        @endif
                                    @endforeach
								</td>
								<td>{{$user->email}}</td>
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
