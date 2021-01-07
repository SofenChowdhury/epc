{{--@extends('backEnd.master')--}}
{{--@section('mainContent')--}}
{{--    <div class="row">--}}
{{--        <div class="col-md-4">--}}
{{--            @if(session()->has('message-success'))--}}
{{--                <div class="alert alert-success mb-3 background-success" role="alert">--}}
{{--                    {{ session()->get('message-success') }}--}}
{{--                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--                        <span aria-hidden="true">&times;</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            @elseif(session()->has('message-danger'))--}}
{{--                <div class="alert alert-danger">--}}
{{--                    {{ session()->get('message-danger') }}--}}
{{--                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--                        <span aria-hidden="true">&times;</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--            @if(session()->has('message-success-delete'))--}}
{{--                <div class="alert alert-danger mb-3 background-danger" role="alert">--}}
{{--                    {{ session()->get('message-success-delete') }}--}}
{{--                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--                        <span aria-hidden="true">&times;</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            @elseif(session()->has('message-danger-delete'))--}}
{{--                <div class="alert alert-danger">--}}
{{--                    {{ session()->get('message-danger-delete') }}--}}
{{--                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--                        <span aria-hidden="true">&times;</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--            @can('Add/Edit Indent')--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h5>Add New Indent</h5>--}}
{{--                    </div>--}}
{{--                    <div class="card-block">--}}
{{--                        @if(isset($editData))--}}
{{--                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'insert/'.$editData->id, 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}--}}
{{--                        @else--}}
{{--                            {{ Form::open(['class' => '', 'files' => true, 'url' => 'insert',--}}
{{--                            'method' => 'POST', 'enctype' => 'multipart/form-data']) }}--}}
{{--                        @endif--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label class="col-form-label"><span class="important">*</span> Name of Indent/Paid to</label>--}}
{{--                                    <input type="text" class="form-control {{ $errors->has('vendor') ? ' is-invalid' : '' }}" name="vendor" id="vendor" value="{{isset($editData)? $editData->vendor : old('vendor') }}">--}}
{{--                                    <p style="color: darkred">Maximum 50 characters</p>--}}
{{--                                    @if ($errors->has('vendor'))--}}
{{--                                        <span class="invalid-feedback" role="alert">--}}
{{--                                            <span class="messages"><strong>{{ $errors->first('vendor') }}</strong></span>--}}
{{--                                        </span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label class="col-form-label"><span class="important">*</span> Purpose of Payment</label>--}}
{{--                                    <input type="text" class="form-control {{ $errors->has('purpose') ? ' is-invalid' : '' }}" name="purpose" id="purpose" value="{{isset($editData)? $editData->purpose : old('purpose') }}">--}}
{{--                                    <p style="color: darkred">Maximum 50 characters</p>--}}
{{--                                    @if ($errors->has('purpose'))--}}
{{--                                        <span class="invalid-feedback" role="alert">--}}
{{--                                            <span class="messages"><strong>{{ $errors->first('purpose') }}</strong></span>--}}
{{--                                        </span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label class="col-form-label"><span class="important">*</span> Project Exp Code</label>--}}
{{--                                    <input type="text" class="form-control {{ $errors->has('code') ? ' is-invalid' : '' }}" name="code" id="code" value="{{isset($editData)? $editData->code : old('code') }}">--}}
{{--                                    <p style="color: darkred">Maximum 50 characters</p>--}}
{{--                                    @if ($errors->has('code'))--}}
{{--                                        <span class="invalid-feedback" role="alert">--}}
{{--                                            <span class="messages"><strong>{{ $errors->first('code') }}</strong></span>--}}
{{--                                        </span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label class="col-form-label"><span class="important">*</span> Amount</label>--}}
{{--                                    <input type="number" class="form-control {{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" id="amount" value="{{isset($editData)? $editData->amount : old('amount') }}">--}}
{{--                                    <p style="color: darkred">Maximum 50 characters</p>--}}
{{--                                    @if ($errors->has('amount'))--}}
{{--                                        <span class="invalid-feedback" role="alert">--}}
{{--                                            <span class="messages"><strong>{{ $errors->first('amount') }}</strong></span>--}}
{{--                                        </span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label class="col-form-label"><span class="important"></span> Remark</label>--}}
{{--                                    <input type="text" class="form-control" name="remark" id="remark" value="{{isset($editData)? $editData->remark : old('remark') }}">--}}
{{--                                    <p style="color: darkred">Maximum 50 characters</p>--}}
{{--                                    @if ($errors->has('remark'))--}}
{{--                                        <span class="invalid-feedback" role="alert">--}}
{{--                                            <span class="messages"><strong>{{ $errors->first('remark') }}</strong></span>--}}
{{--                                        </span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row mt-4">--}}
{{--                            <div class="col-sm-12 text-center">--}}
{{--                                <button type="submit" class="btn btn-primary m-b-0">Submit</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        {{ Form::close()}}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endcan--}}
{{--        </div>--}}
{{--        @can('View Indent List')--}}
{{--            <div class="col-md-8">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h5>Indent List</h5>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-2 md-layout-item">--}}
{{--                        <label for="voucher_no" class="col-form-label">Voucher No:</label>--}}
{{--                        <input type="text" class="form-control p-1" required readonly value="{{rand()}}" name="voucher_no" id="voucher_no"/>--}}
{{--                    </div>--}}
{{--                    <table class="table table-striped table-bordered">--}}
{{--                        <tr>--}}
{{--                            <th>SR.Acc</th>--}}
{{--                            <th>Manager</th>--}}
{{--                            <th>Ass.Director</th>--}}
{{--                            <th>Director-2</th>--}}
{{--                            <th>Director-1</th>--}}
{{--                            <th>Chairman</th>--}}
{{--                        </tr>--}}
{{--                        <tr>--}}
{{--                            <td><button class="btn btn-primary">Approve</button></td>--}}
{{--                            <td><button class="btn btn-primary">Approve</button></td>--}}
{{--                            <td><button class="btn btn-primary">Approve</button></td>--}}
{{--                            <td><button class="btn btn-primary">Approve</button></td>--}}
{{--                            <td><button class="btn btn-primary">Approve</button></td>--}}
{{--                            <td><button class="btn btn-primary">Approve</button></td>--}}
{{--                        </tr>--}}
{{--                    </table>--}}
{{--                    <div class="card-block">--}}
{{--                        {{ Form::open(['class' => '', 'files' => true, 'url' => 'select',--}}
{{--                            'method' => 'GET', 'enctype' => 'multipart/form-data'])}}--}}
{{--                        <div class="dt-responsive table-responsive">--}}
{{--                            <table id="basic-btn" class="table table-striped table-bordered">--}}
{{--                                <thead>--}}
{{--                                <tr>--}}
{{--                                    <th>VN {{rand()}}</th>--}}
{{--                                    <th>Name of Indent/Paid to</th>--}}
{{--                                    <th>Purpose of Payment</th>--}}
{{--                                    <th>Project Exp Code</th>--}}
{{--                                    <th>Amount</th>--}}
{{--                                    <th>Remark</th>--}}
{{--                                    <th>Action</th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}
{{--                                    @if(isset($indent_value))--}}
{{--                                        @php $i = 1 @endphp--}}
{{--                                        @foreach($indent_value as $value)--}}
{{--                                            <tr>--}}
{{--                                                <td>{{$i++}}</td>--}}
{{--                                                <td>{{$value->vendor}}</td>--}}
{{--                                                <td>{{$value->purpose}}</td>--}}
{{--                                                <td>{{$value->code}}</td>--}}
{{--                                                <td>{{$value->amount}}</td>--}}
{{--                                                <td>{{$value->remark}}</td>--}}
{{--                                                <td>--}}
{{--                                                    @can('Add/Edit Indent')--}}
{{--                                                        <a href="{{url('select/'.$value->id.'/edit')}}" title="Edit"><button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button></a>--}}
{{--                                                    @endcan--}}

{{--                                                    @if(Auth::user()->getRoleNames()->first() == 'Super Admin')--}}
{{--                                                        <a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteView', $value->id)}}">--}}
{{--                                                            <button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>--}}
{{--                                                        </a>--}}
{{--                                                    @endif--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                        @endforeach--}}
{{--                                    @endif--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row mt-4">--}}
{{--                            <div class="col-sm-12 text-center">--}}
{{--                                <button type="submit" class="btn btn-primary m-b-0">Assign</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        {{ Form::close()}}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endcan--}}
{{--    </div>--}}
{{--@endSection--}}
