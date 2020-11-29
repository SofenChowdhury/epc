@extends('backEnd.master')
@section('mainContent')
    <div class="card">
        <div class="card-header">
            <h5>Edit Advance Payment </h5>
        </div>
        <div class="card-block">
            {{ Form::open(['class' => '', 'files' => true, 'url' => 'project_advance/'.$editData->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
            @csrf
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="employee"><strong> Amendment No:</strong></label>
                    <select
                        class="js-example-basic-single col-sm-12 {{ $errors->has('amendment') ? ' is-invalid' : '' }}"
                        name="amendment" id="amendment">
                        <option value="">Select Amendment No</option>
                        @if(isset($maxAmendmentAdvance))
                            @for($y=1; $y<=$maxAmendmentAdvance; $y++)
                                <option
                                    value="{{ $y}}">{{$y}}</option>
                            @endfor
                        @endif
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="amount"><span class="important">*</span> Advance Amount : </label>
                    <input type="number" step="0.01" class="form-control  {{ $errors->has('amount') ? ' is-invalid' : '' }}" value="{{ $editData->amount }}" name="amount" />
                    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('amount') }}</strong></span>
						</span>
                </div>

                <div class="form-group col-md-6">
                    <label for="receive_date">Receive Date :</label>
                    <input type="" class="form-control datepicker {{ $errors->has('receive_date') ? ' is-invalid' : '' }}" value="{{ $editData->receive_date }}" name="receive_date" />
                    @if ( $errors->has('receive_date') )
                        <span class="invalid-feedback" role="alert" >
                                <span class="messages"><strong>{{ $errors->first('receive_date') }}</strong></span>
                            </span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="bank_name">Bank Name :</label>
                    <input type="" class="form-control {{ $errors->has('bank_name') ? ' is-invalid' : '' }}" value="{{ $editData->bank_name }}" name="bank_name"/>
                    @if ($errors->has('bank_name'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('bank_name') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="guarantee_amount">Guarantee Amount :</label>
                    <input type="number" step="0.01" class="form-control {{ $errors->has('guarantee_amount') ? ' is-invalid' : '' }}" value="{{ $editData->guarantee_amount }}" name="guarantee_amount"/>
                    @if ($errors->has('guarantee_amount'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('guarantee_amount') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="effective_through">Effective Through :</label>
                    <input type="" class="form-control datepicker {{ $errors->has('effective_through') ? ' is-invalid' : '' }}" value="{{ $editData->effective_through }}" name="effective_through" />
                    @if ( $errors->has('effective_through') )
                        <span class="invalid-feedback" role="alert" >
                                <span class="messages"><strong>{{ $errors->first('effective_through') }}</strong></span>
                            </span>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="description">Description :</label>
                    <textarea class="form-control" name="description">{{ $editData->description }}</textarea>
                    <p style="color: darkred">Maximum 350 characters</p>
                    @if ( $errors->has('description') )
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('description') }}</strong></span>
						</span>
                    @endif
                </div>
            </div>

            <div class="form-group row mt-5">
                <div class="col-sm-6 text-center" style="margin-bottom: 1em;">
                    <a class="" title="Back" href="{{url('/project',$editData->project_id)}}">
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

@endSection
