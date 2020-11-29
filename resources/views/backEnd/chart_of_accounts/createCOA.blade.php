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
            @can('Add New COA')
                <div class="card">

                    <div class="card-header">
                        <h5>Add New Chart of Account</h5>
                    </div>
                    <div class="card-block">

                        @if(isset($editData))
                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'editCOA/'.$editData->id, 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        @else
                            {{ Form::open(['class' => '', 'files' => true, 'url' => 'storeCOA',
                            'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group coa_parent">
                                    <label class="col-form-label"><span class="important">*</span>Chart of Account</label>
                                    <select class="js-example-basic-single col-sm-12 {{ $errors->has('coa_parent') ? ' is-invalid' : '' }}" name="coa_parent" id="coa_parent" {{isset($editData)? 'disabled' : ''}} required>
                                        @if(isset($coas))
                                            @foreach($coas as $key=>$value)
                                                @if($value->coa_parent == null)
                                                    <option value="{{$value->coa_reference_no}}"
                                                            @if(isset($editData))
                                                            @if($editData->coa_parent == $value->coa_reference_no)
                                                            readonly="true" selected
                                                        @endif
                                                        @endif
                                                    >{{$value->coa_reference_no}} {{$value->coa_name}}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('coa_parent'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('coa_parent') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            {{--                            <div class="form-group input-effect col-md-12">--}}
                            {{--                                <label class="col-form-label"><span class="important">*</span>Account ID</label>--}}
                            {{--                                <input type="text" class="form-control {{ $errors->has('coa_reference_no') ? ' is-invalid' : '' }}" name="coa_reference_no" id="coa_reference_no" value="{{isset($editData)? $editData->coa_reference_no : old('coa_reference_no')}}" {{isset($editData)? 'readonly' : ''}} required>--}}
                            {{--                                @if ($errors->has('coa_reference_no'))--}}
                            {{--                                    <span class="invalid-feedback" role="alert">--}}
                            {{--                                        <span class="messages"><strong>{{ $errors->first('coa_reference_no') }}</strong></span>--}}
                            {{--                                    </span>--}}
                            {{--                                @endif--}}
                            {{--                            </div>--}}
                            <div class="form-group input-effect col-md-12">
                                <label class="col-form-label"><span class="important">*</span> Accounts Name</label>
                                <input type="text" class="form-control {{ $errors->has('coa_name') ? ' is-invalid' : '' }}" name="coa_name" id="coa_name" value="{{isset($editData)? $editData->coa_name : old('coa_name')}}" required>
                                <p style="color: darkred">Maximum 150 characters</p>
                                @if ($errors->has('coa_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <span class="messages"><strong>{{ $errors->first('coa_name') }}</strong></span>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-12">
                                <label for="account_type"><span class="important">*</span> Account Type</label>
                                <select class="js-example-basic-single col-sm-12 {{ $errors->has('account_type') ? ' is-invalid' : '' }}" name="account_type" id="account_type" {{isset($editData)? 'disabled' : ''}} required>
                                    <option value="">Select account type</option>
                                    <option value="debit"
                                            @if(isset($editData) && $editData->account_type == 'debit') selected @endif
                                    >Debit</option>
                                    <option value="credit"
                                            @if(isset($editData) && $editData->account_type == 'credit') selected @endif
                                    >Credit</option>
                                </select>
                                @if ($errors->has('account_type'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('account_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group input-effect col-md-12">
                                <div class="" style="margin-top: 22px !important;">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="debit_credit_amount" id="debit_amount" value="debit"
                                            @if(isset($editData)) {{ $editData->opening_debit == 1 ? 'checked' : '' }} @endif
                                            > Debit amount
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="debit_credit_amount" id="credit_amount" value="credit"
                                            @if(isset($editData)) {{ $editData->opening_credit == 1 ? 'checked' : '' }} @endif
                                            > Credit amount
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="debit_div form-group input-effect col-md-12" style="{{isset($editData) ? ( $editData->opening_credit==1 ? 'display: none' : '') : ''}}">
                                <label class="col-form-label">Opening Debit Amount</label>
                                <input type="number" step="0.01" class="form-control" name="opening_debit_amount" value="{{isset($editData) ? $editData->opening_debit_amount : old('opening_debit_amount')}}">
                                @if ($errors->has('opening_debit_amount'))
                                    <span class="invalid-feedback" role="alert">
                                <span class="messages"><strong>{{ $errors->first('opening_debit_amount') }}</strong></span>
                            </span>
                                @endif
                            </div>
                            <div class="credit_div form-group input-effect col-md-12" style="{{isset($editData) ? ( $editData->opening_debit==1 ? 'display: none' : ( $editData->opening_credit==1 ? '' : 'display: none')) : 'display: none'}}">
                                <label class="col-form-label">Opening Credit Amount</label>
                                <input type="number" step="0.01" class="form-control" name="opening_credit_amount" value="{{isset($editData) ? $editData->opening_credit_amount : old('opening_credit_amount')}}">
                                @if ($errors->has('opening_credit_amount'))
                                    <span class="invalid-feedback" role="alert">
                                <span class="messages"><strong>{{ $errors->first('opening_credit_amount') }}</strong></span>
                            </span>
                                @endif
                            </div>
                            <div class="form-group row col-md-12">
                                <div class="col-sm-6 text-center">
                                    <a class="" title="Back" href="{{url('create-coa')}}">
                                        <button type="button" class="btn btn-primary m-b-0">Cancel</button>
                                    </a>
                                </div>
                                <div class="col-sm-6 text-center">
                                    <button type="submit" class="btn btn-primary m-b-0">Submit</button>
                                </div>
                            </div>
                            {{ Form::close()}}

                        </div>
                    </div>

                </div>
            @endcan
        </div>
        @can('View COA List')
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Chart of Accounts Lists</h5>
                    </div>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table id="basic-btn" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>SL No.</th>
                                    <th>Account No</th>
                                    <th>Account Name</th>
                                    <th>Account Head</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($coas))
                                    @php $i = 1 @endphp
                                    @foreach($coas as $coa)
                                        {{-- @if(isset($value->coa_parent))--}}
                                        @if($coa->coa_parent != NULL)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                {{--										<td>{{$value->accountCategory->category_name}}</td>--}}
                                                {{--										<td>{{$value->coa_name}}</td>--}}
                                                <td>{{$coa->coa_reference_no}}</td>
                                                <td>{{$coa->coa_name}}</td>
                                                <td>@if(isset($coa->parent)) {{$coa->parent->coa_name}} @endif</td>
                                                <td>
                                                    <a href="{{url('edit-coa/'.$coa->id)}}" title="edit"><button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button></a>
                                                </td>
                                            </tr>
                                        @endif
                                        {{-- @endif--}}
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>

@endSection
