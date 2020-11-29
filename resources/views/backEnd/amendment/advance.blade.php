@extends('backEnd.master')
@section('mainContent')
    <div class="card">
        <div class="card-header">
            <h5>Add Amendment Advance Payment for Project : {{ $project->project_name}} </h5>
        </div>
        <div class="card-block">
            {{ Form::open(['class' => '', 'files' => true, 'url' => 'project_advance/create/amendment/'.$project->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
            {{csrf_field()}}
            <input type="hidden" name="amendment" value="{{$maxAmendmentAdvance+1}}">


            <div class="row">
                <div class="form-group col-md-3">
                    <label for="title"><strong>Amendment No:</strong></label>
                    <input type="number" class="form-control {{ $errors->has('amendment') ? ' is-invalid' : '' }}"
                           value="{{$maxAmendmentAdvance+1}}"  disabled/>
                    @if ($errors->has('amendment'))
                        <span class="invalid-feedback" role="alert">
                                                            <span
                                                                class="messages"><strong>{{ $errors->first('amendment') }}</strong></span>
                                                        </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="amount"><span class="important">*</span> Advance Amount : </label>
                    <input type="number" step="0.01" class="form-control  {{ $errors->has('amount') ? ' is-invalid' : '' }}" value="{{ old('amount') }}" name="amount" />
                    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('amount') }}</strong></span>
						</span>
                </div>

                <div class="form-group col-md-6">
                    <label for="receive_date">Receive Date :</label>
                    <input type="" class="form-control datepicker {{ $errors->has('receive_date') ? ' is-invalid' : '' }}" value="{{ old('receive_date') }}" name="receive_date" />
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
                    <input type="" class="form-control {{ $errors->has('bank_name') ? ' is-invalid' : '' }}" value="{{ old('bank_name') }}" name="bank_name"/>
                    @if ($errors->has('bank_name'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('bank_name') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="guarantee_amount">Guarantee Amount :</label>
                    <input type="number" step="0.01" class="form-control {{ $errors->has('guarantee_amount') ? ' is-invalid' : '' }}" value="{{ old('guarantee_amount') }}" name="guarantee_amount"/>
                    @if ($errors->has('guarantee_amount'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('guarantee_amount') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="effective_through">Effective Through :</label>
                    <input type="" class="form-control datepicker {{ $errors->has('effective_through') ? ' is-invalid' : '' }}" value="{{ old('effective_through') }}" name="effective_through" />
                    @if ( $errors->has('effective_through') )
                        <span class="invalid-feedback" role="alert" >
                                <span class="messages"><strong>{{ $errors->first('effective_through') }}</strong></span>
                            </span>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="description">Description :</label>
                    <textarea class="form-control" value="{{ old('description') }}" name="description"></textarea>
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
                    <a class="" title="Back" href="{{url('/project',$project->id)}}">
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
