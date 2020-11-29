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
            @can('Add/ Edit Conveyance Schedule')
                <div class="card">
                    <div class="card-header">
                        <h5>Add New Conveyance Schedule</h5>
                    </div>
                    <div class="card-block">
                        @if(isset($editData))
                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'conveyance/'.$editData->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                        @else
                            {{ Form::open(['class' => '', 'files' => true, 'url' => 'conveyance',
                            'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="destination"><span class="important">*</span> Destination</label>
                                    <input type="text" class="form-control {{ $errors->has('destination') ? ' is-invalid' : '' }}" name="destination" id="destination" value="{{isset($editData)? $editData->destination : old('destination') }}" required>
                                    <p style="color: darkred">Maximum 200 characters</p>
                                    @if ($errors->has('destination'))
                                        <span class="invalid-feedback" role="alert"><span class="messages"><strong>{{ $errors->first('destination') }}</strong></span></span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mode">Mode</label>
                                    <input type="text" class="form-control {{ $errors->has('mode') ? ' is-invalid' : '' }}" name="mode" id="mode" value="{{isset($editData)? $editData->mode : old('mode') }}">
                                    <p style="color: darkred">Maximum 100 characters</p>
                                    @if ($errors->has('mode'))
                                        <span class="invalid-feedback" role="alert"><span class="messages"><strong>{{ $errors->first('mode') }}</strong></span></span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="rate"><span class="important">*</span> Rate</label>
                                    <input type="number" step="0.01" class="form-control {{ $errors->has('rate') ? ' is-invalid' : '' }}" name="rate" id="rate" value="{{isset($editData)? $editData->rate : old('rate') }}">
                                    @if ($errors->has('rate'))
                                        <span class="invalid-feedback" role="alert"><span class="messages"><strong>{{ $errors->first('rate') }}</strong></span></span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="remark">Remark</label>
                                    <textarea class="form-control" name="remark">{{ isset($editData) ? $editData->remark : old('remark') }}</textarea>
                                    @if ($errors->has('remark'))
                                        <span class="invalid-feedback" role="alert"><span class="messages"><strong>{{ $errors->first('remark') }}</strong></span></span>
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

            @role('Super Admin')
            <div class="card">
                <div class="card-header">
                    <h5>Increase Conveyance Rate</h5>
                </div>
                <div class="card-block">
                    {{ Form::open(['class' => '', 'files' => true, 'url' => 'increase_conveyance', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'on']) }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="increased_rate"><span class="important">*</span> Increaded Conveyance Rate (by %)</label>
                                <input type="number" class="form-control {{ $errors->has('increased_rate') ? ' is-invalid' : '' }}" name="increased_rate" value="{{ old('increased_rate') }}">
                                @if ($errors->has('increased_rate'))
                                    <span class="invalid-feedback" role="alert"><span class="messages"><strong>{{ $errors->first('increased_rate') }}</strong></span></span>
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
            @endrole
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Conveyance Schedule</h5>
                </div>
                <div class="card-block">
                    <div class="table-responsive">
                        <table id="basic-btn" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Destination</th>
                                <th>Mode</th>
                                <th>Rate</th>
                                <th>Remark</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($conveyances))
                                @php $i = 1 @endphp
                                @foreach($conveyances as $conveyance)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$conveyance->destination}}</td>
                                        <td>{{$conveyance->mode}}</td>
                                        <td>{{$conveyance->rate}}</td>
                                        <td>{{$conveyance->remark}}</td>
                                        <td>
                                            @can('Add/ Edit Conveyance Schedule')
                                                <a href="{{url('conveyance/'.$conveyance->id.'/edit')}}" title="Edit"><button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button></a>
                                            @endcan
                                            @role('Super Admin')
                                            <a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteConveyanceView', $conveyance->id)}}">
                                                <button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>
                                            </a>
                                            @endrole
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
