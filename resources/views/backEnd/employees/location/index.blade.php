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
            @can('Add/Edit Location')
                <div class="card">
                    <div class="card-header">
                        <h5>Add New Room Number</h5>
                    </div>
                    <div class="card-block">
                        @if(isset($editData))
                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'location/'.$editData->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                        @else
                            {{ Form::open(['class' => '', 'files' => true, 'url' => 'location',
                            'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="room_no"><span class="important">*</span> Room Number</label>
                                    <input type="" class="form-control {{ $errors->has('room_no') ? ' is-invalid' : '' }}" name="room_no" value="{{isset($editData)? $editData->room_no : old('room_no') }}">
                                    @if ($errors->has('room_no'))
                                        <span class="invalid-feedback" role="alert">
                                            <span class="messages"><strong>{{ $errors->first('room_no') }}</strong></span>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="floor_no">Floor Number</label>
                                    <input type="text" class="form-control {{ $errors->has('floor_no') ? ' is-invalid' : '' }}" name="floor_no" id="floor_no" value="{{isset($editData)? $editData->floor_no : old('floor_no') }}">
                                    @if ($errors->has('floor_no'))
                                        <span class="invalid-feedback" role="alert">
                                            <span class="messages"><strong>{{ $errors->first('floor_no') }}</strong></span>
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
            <div class="card">
                <div class="card-header">
                    <h5>Room Numbers </h5>
                </div>
                <div class="card-block">
                    <div class="dt-responsive table-responsive">
                        <table id="basic-btn" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Room Number</th>
                                <th>Floor Number</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($rooms))
                                @php $i = 1 @endphp
                                @foreach($rooms as $room)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$room->room_no}}</td>
                                        <td>{{$room->floor_no}}</td>
                                        <td>
                                            @can('Add/Edit Location')
                                                <a href="{{url('location/'.$room->id.'/edit')}}" title="edit"><button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button></a>
                                            @endcan
                                            <a href="{{url('location/assets/'.$room->id)}}" title="assets"><button type="button" class="btn btn-success action-icon">Assets/ Employees</button></a>
{{--                                            <a href="{{url('location/employees/'.$room->id)}}" title="assets"><button type="button" class="btn btn-success action-icon">Employees</button></a>--}}
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
