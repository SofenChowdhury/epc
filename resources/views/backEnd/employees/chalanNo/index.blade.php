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
            @can('Add Chalan Number')
                <div class="card">
                    <div class="card-header">
                        <h5>Add Chalan No</h5>
                    </div>
                    <div class="card-block">
                        @if(isset($editData))
                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'chalan_no/'.$editData->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                        @else
                            {{ Form::open(['class' => '', 'files' => true, 'url' => 'chalan_no',
                            'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                        @endif
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="col-form-label"><span class="important">*</span> Chalan Number</label>
                                <input type="text" class="form-control {{ $errors->has('chalan_no') ? ' is-invalid' : '' }}" name="chalan_no" id="chalan_no" placeholder="Chalan Number" value="{{isset($editData)? $editData->chalan_no : old('chalan_no') }}">
                                <p style="color: darkred">Maximum 100 characters</p>

                                @if ($errors->has('chalan_no'))
                                    <span class="invalid-feedback" role="alert">
                                            <span class="messages"><strong>{{ $errors->first('chalan_no') }}</strong></span>
                                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="chalan_date">Date  </label>
                                <input type="" class="form-control datepicker {{ $errors->has('chalan_date') ? ' is-invalid' : '' }}" value="{{isset($editData)? $editData->chalan_date : old('chalan_date') }}" name="chalan_date"/>
                                @if ($errors->has('chalan_date'))
                                    <span class="invalid-feedback" role="alert" >
                                        <span class="messages"><strong>{{ $errors->first('chalan_date') }}</strong></span>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="bank_name">Bank Name</label>
                                <input type="text" class="form-control {{ $errors->has('bank_name') ? ' is-invalid' : '' }}" value="{{isset($editData)? $editData->bank_name : old('bank_name') }}" name="bank_name"/>
                                <p style="color: darkred">Maximum 100 characters</p>
                                @if ($errors->has('bank_name'))
                                    <span class="invalid-feedback" role="alert" >
                                        <span class="messages"><strong>{{ $errors->first('bank_name') }}</strong></span>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="start_month">Chalan Start month </label>
                                <input type="" class="form-control datepicker {{ $errors->has('start_month') ? ' is-invalid' : '' }}" value="{{isset($editData)? $editData->start_month : old('start_month') }}" name="start_month"/>
                                @if ($errors->has('start_month'))
                                    <span class="invalid-feedback" role="alert" >
                                    <span class="messages"><strong>{{ $errors->first('start_month') }}</strong></span>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="end_month">End month </label>
                                <input type="" class="form-control datepicker {{ $errors->has('end_month') ? ' is-invalid' : '' }}" value="{{isset($editData)? $editData->end_month : old('end_month') }}" name="end_month"/>
                                @if ($errors->has('end_month'))
                                    <span class="invalid-feedback" role="alert" >
                                    <span class="messages"><strong>{{ $errors->first('end_month') }}</strong></span>
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
            @endcan
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Incentive Lists</h5>
                </div>
                <div class="card-block">
                    <div class="dt-responsive table-responsive">
                        <table id="basic-btn" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Chalan No</th>
                                <th>Date</th>
                                <th>Bank Name</th>
                                <th>Start month</th>
                                <th>End month</th>
                                @can('Edit Chalan Number')
                                <th>Actions</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($chalans))
                                @php $i = 1 @endphp
                                @foreach($chalans as $chalan)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$chalan->chalan_no}}</td>
                                        <td>{{date('d-m-Y', strtotime($chalan->chalan_no))}}</td>
                                        <td>{{$chalan->bank_name}}</td>
                                        <td>{{date('M Y', strtotime($chalan->start_month))}}</td>
                                        <td>{{date('M Y', strtotime($chalan->end_month))}}</td>
                                        <td>
                                            @can('Edit Chalan Number')
                                                <a href="{{url('chalan_no/'.$chalan->id.'/edit')}}" title="Edit"><button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button></a>
                                            @endcan
{{--                                            @if(Auth::user()->getRoleNames()->first() == 'Super Admin')--}}
{{--                                                <a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteIncentiveView', $chalan->id)}}">--}}
{{--                                                    <button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>--}}
{{--                                                </a>--}}
{{--                                            @endif--}}
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
