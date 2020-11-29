@extends('backEnd.master')
@section('mainContent')
    <div class="row">
        <div class="col-md-4">

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
                    <h5>Edit COA</h5>
                </div>
                <div class="card-block">
                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'update_coa/'.$editData->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group input-effect">
                                <label class="col-form-label">Accounts Name</label>

                                <input type="text" class="form-control {{ $errors->has('coa_name') ? ' is-invalid' : '' }}" name="coa_name" id="coa_name" placeholder="" value="{{ $editData->coa_name }}">

                                @if ($errors->has('coa_name'))
                                    <span class="invalid-feedback" role="alert">
									<span class="messages"><strong>{{ $errors->first('coa_name') }}</strong></span>
								</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="col-form-label">Accounts Category</label>
                                <select class="js-example-basic-single col-sm-12 {{ $errors->has('coa_category') ? ' is-invalid' : '' }}" name="coa_category" id="coa_category">
                                    <option value="">Select Account Category</option>
                                    @if(isset($category))
                                        @foreach($category as $key=>$value)
                                            <option value="{{$value->id}}"
                                                    @if(isset($editData))
                                                    @if($editData->coa_category == $value->id)
                                                    selected
                                                @endif
                                                @endif
                                            >{{$value->category_name}}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('coa_category'))
                                    <span class="invalid-feedback invalid-select" role="alert">
									<strong>{{ $errors->first('coa_category') }}</strong>
								</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="col-form-label">Project</label>
                                <select class="js-example-basic-single col-sm-12 {{ $errors->has('project_id') ? ' is-invalid' : '' }}" name="project_id" id="project_id">
                                    <option value="">Select Your Project</option>
                                    @if(isset($projects))
                                        @foreach($projects as $key=>$value)
                                            <option value="{{$value->id}}"
                                                    @if(isset($editData))
                                                    @if($editData->coa_category == $value->id)
                                                    selected
                                                @endif
                                                @endif
                                            >{{$value->project_name}}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('project_id'))
                                    <span class="invalid-feedback invalid-select" role="alert">
									<strong>{{ $errors->first('project_id') }}</strong>
								</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <div class="">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="debit_credit_amount" id="debit_amount" value="debit" @if( !is_null( $editData->opening_debit_amount) ) checked @endif> Debit amount
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="debit_credit_amount" id="credit_amount" value="credit" @if( !is_null( $editData->opening_credit_amount) ) checked @endif> Credit amount
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="debit_div" @if( is_null( $editData->opening_debit_amount) ) style='display:none'; @endif>
                                <div class="form-group">
                                    <label class="col-form-label">Opening Debit Amount</label>
                                    <input type="number" step="0.01" class="form-control {{ $errors->has('opening_debit_amount') ? ' is-invalid' : '' }}" name="opening_debit_amount" id="opening_debit_amount" placeholder="" value="{{old('opening_debit_amount')}}">
                                    @if ($errors->has('opening_debit_amount'))
                                        <span class="invalid-feedback" role="alert">
										<span class="messages"><strong>{{ $errors->first('opening_debit_amount') }}</strong></span>
									</span>
                                    @endif
                                </div>
                            </div>
                            <div class="credit_div" @if( is_null( $editData->opening_credit_amount) ) style='display:none'; @endif>
                                <div class="form-group">
                                    <label class="col-form-label">Opening Credit Amount</label>
                                    <input type="number" step="0.01" class="form-control {{ $errors->has('opening_credit_amount') ? ' is-invalid' : '' }}" name="opening_credit_amount" id="opening_credit_amount" placeholder="" value="{{old('opening_credit_amount')}}">
                                    @if ($errors->has('opening_credit_amount'))
                                        <span class="invalid-feedback" role="alert">
										<span class="messages"><strong>{{ $errors->first('opening_credit_amount') }}</strong></span>
									</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">Accounts Class</label>
                                <select class="js-example-basic-single col-sm-12 {{ $errors->has('coa_class') ? ' is-invalid' : '' }}" name="account_parent" id="coa_class">
                                    <option value="">Select Account Class</option>
                                    @if(isset($coaClass))
                                        @foreach($coaClass as $key=>$value)
                                            <option value="{{$value->id}}"
                                                    @if(isset($editData))
                                                    @if($editData->coa_class == $value->id)
                                                    selected
                                                @endif
                                                @endif
                                            >{{$value->class_name}}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('coa_class'))
                                    <span class="invalid-feedback invalid-select" role="alert">
									<strong>{{ $errors->first('coa_class') }}</strong>
								</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="col-form-label">Accounts Parent</label>
                                <select class="js-example-basic-single col-sm-12 {{ $errors->has('coa_parent') ? ' is-invalid' : '' }}" name="coa_parent" id="coa_parent">
                                    <option value="">Select Account Class</option>
                                    @if(isset($allChartsOfAccounts))
                                        @foreach($allChartsOfAccounts as $key=>$value)
                                            <option value="{{$value->id}}"
                                                    @if(isset($editData))
                                                    @if($editData->coa_class == $value->id)
                                                    selected
                                                @endif
                                                @endif
                                            >{{$value->coa_name}}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('coa_parent'))
                                    <span class="invalid-feedback invalid-select" role="alert">
									<strong>{{ $errors->first('coa_parent') }}</strong>
								</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Level</label>
                                <input type="text" class="form-control {{ $errors->has('coa_level') ? ' is-invalid' : '' }}" name="coa_level" id="coa_level" placeholder="" value="{{old('coa_level')}}">
                                @if ($errors->has('coa_level'))
                                    <span class="invalid-feedback" role="alert">
									<span class="messages"><strong>{{ $errors->first('coa_level') }}</strong></span>
								</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mt-4">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-primary m-b-0">Update</button>
                        </div>
                    </div>
                    {{ Form::close()}}
                </div>
            </div>
        </div>

    </div>

@endSection
