@extends('backEnd.master')
@section('mainContent')
    @role('Super Admin')
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
                    <h5>Add New Authorization</h5>
                </div>
                <div class="card-block">
                    @if(isset($editData))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'authorize/'.$editData->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                    @else
                        {{ Form::open(['class' => '', 'files' => true, 'url' => 'authorize', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="serial_no"><span class="important">*</span> Serial Number</label>
                                <input type="number" class="form-control {{ $errors->has('serial_no') ? ' is-invalid' : '' }}" name="serial_no" id="serial_no" value="{{ isset($editData)? $editData->serial_no : (isset($next)? $next : 1) }}">
                                @if ($errors->has('serial_no'))
                                    <span class="invalid-feedback" role="alert"><span class="messages"><strong>{{ $errors->first('serial_no') }}</strong></span></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="user_id"><span class="important">*</span> Employee Name : </label>
                            <select class="js-example-basic-single col-sm-12 {{ $errors->has('user_id') ? ' is-invalid' : '' }}" name="user_id" id="user_id">
                                <option value="">Select Employee </option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ isset($editData) && ($editData->user_id == $user->id) ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @if ( $errors->has('user_id') )
                                <span class="invalid-feedback" role="alert" >
                                            <span class="messages"><strong>{{ $errors->first('user_id') }}</strong></span>
                                </span>
                            @endif
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
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Authorization Lists</h5>
                </div>
                <div class="card-block">
                    <div class="dt-responsive table-responsive">
                        <table id="basic-btn" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Serial Number</th>
{{--                        edite here--}}
                                <th>Employee Name</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($authorizes))
                                @foreach($authorizes as $authorize)
                                    <tr>

                                        <td>{{$authorize->serial_no}}</td>
                                        <td>{{$authorize->name}}</td>

                                        <td>
                                            <a href="{{url('authorize/'.$authorize->id.'/edit')}}" title="edit"><button type="button" class="btn btn-info action-icon">Edit</button></a>
                                            <a href="{{url('deleteAuthorize', $authorize->id)}}" title="Delete" onclick="return confirm('Are you sure?')">
                                                <button type="button" class="btn btn-danger action-icon">Delete</button>
                                            </a>
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
    @endrole
@endSection
