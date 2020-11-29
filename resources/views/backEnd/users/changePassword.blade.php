@extends('backEnd.master')
@section('mainContent')
    <div class="row">
        <div ></div>
        <div class="col-md-6">

            @if(session()->has('message-danger'))
                <div class="alert alert-danger">
                    {{ session()->get('message-danger') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5>Change Password</h5>
                </div>
                <div class="card-block">
                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'user/changePassword/'.Auth::user()->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data','autocomplete' => 'off']) }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <input id="employee_id" type="text" class="form-control{{ $errors->has('employee_id') ? ' is-invalid' : '' }}" readonly name="employee_id" value="{{ Auth::user()->employee_id }}" hidden>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Employee Name') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ Auth::user()->name }}" readonly>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
				                            <strong>{{ $errors->first('name') }}</strong>
				                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ Auth::user()->email }}" readonly>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
				                            <strong>{{ $errors->first('email') }}</strong>
				                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="role_id" class="col-md-4 col-form-label text-md-right">{{ __('Role ') }}</label>
                                <div class="col-md-6">
                                    <select name="role_id" id="role_id" class="js-example-basic-single col-sm-12" disabled>
                                        @if(isset($roles))
                                            @foreach($roles as $role)
                                                <option value="{{$role->id}}"
                                                    @foreach(Auth::user()->roles as $rol)
                                                        @if($rol->id == $role->id)
                                                        selected
                                                        @endif
                                                    @endforeach
                                                >{{$role->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('role_id'))
                                        <span class="invalid-feedback invalid-select" role="alert">
										<span class="messages"><strong>{{ $errors->first('role_id') }}</strong></span>
									</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="previous_password" class="col-md-4 col-form-label text-md-right">{{ __('Previous Password') }}</label>
                                <div class="col-md-6">
                                    <input id="previous_password" type="password" class="form-control{{ $errors->has('Previous Password') ? ' is-invalid' : '' }}" name="previous_password" value="" autocomplete="off">
                                    @if ($errors->has('previous_password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('previous_password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group row mt-4">
                        <div class="col-sm-2 text-center"></div>
                        <div class="col-sm-3 text-center">
                            <a class="" title="Back" href="{{url('/user')}}">
                                <button type="button" class="btn btn-block btn-primary m-b-0">Go Back</button>
                            </a>
                        </div>
                        <div class="col-sm-2 text-center"></div>
                        <div class="col-sm-3 text-center">
                            <button type="submit" class="btn btn-block  btn-primary m-b-0">Update</button>
                        </div>
                    </div>
                    {{ Form::close()}}
                </div>
            </div>
        </div>

    </div>

@endSection
