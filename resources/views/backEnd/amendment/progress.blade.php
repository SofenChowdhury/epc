@extends('backEnd.master')
@section('mainContent')
    <div class="card">
        <div class="card-header">
            <h5>Add Amendment Progress Payment for Project : {{ $project->project_name}} </h5>
        </div>
        <div class="card-block">
            {{ Form::open(['class' => '', 'files' => true, 'url' => 'project_progressPayment', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
            @csrf
            @if(isset($project))
                <div class="row">
                    <div>
                        <input type="text" hidden name="project_id" value="{{ $project->id }}">
                    </div>
                </div>
            @endif
            <input type="hidden" name="amendment" value="{{$maxAmendmentProgress+1}}">
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="title"><strong>Amendment No:</strong></label>
                    <input type="number" class="form-control {{ $errors->has('amendment') ? ' is-invalid' : '' }}"
                           value="{{$maxAmendmentProgress+1}}"  disabled/>
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
                    <label for="amount"><span class="important">*</span> Progress Payment No : </label>
                    <input type="number" class="form-control  {{ $errors->has('p_payment_no') ? ' is-invalid' : '' }}"
                           value="{{ old('p_payment_no') }}" name="p_payment_no"/>
                    <span class="invalid-feedback" role="alert">
							<span class="messages"><strong>{{ $errors->first('p_payment_no') }}</strong></span>
						</span>
                </div>
                <div class="form-group col-md-6">
                    <label for="amount"><span class="important">*</span> Progress Payment Month : </label>
                    <input type="month" class="form-control  {{ $errors->has('p_payment_month') ? ' is-invalid' : '' }}"
                           value="{{ old('p_payment_month') }}" name="p_payment_month"/>
                    <span class="invalid-feedback" role="alert">
							<span class="messages"><strong>{{ $errors->first('p_payment_month') }}</strong></span>
						</span>
                </div>

                <div class="form-group col-md-6">
                    <label for="receive_date"><span class="important">*</span>Invoice Date :</label>
                    <input type=""
                           class="form-control datepicker {{ $errors->has('invoice_date') ? ' is-invalid' : '' }}"
                           value="{{ old('invoice_date') }}" name="invoice_date"/>
                    @if ( $errors->has('invoice_date') )
                        <span class="invalid-feedback" role="alert">
                                <span class="messages"><strong>{{ $errors->first('invoice_date') }}</strong></span>
                            </span>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="amount"><span class="important">*</span> Invoice Amount : </label>
                    <input type="number" step="0.01"
                           class="form-control  {{ $errors->has('invoice_amount') ? ' is-invalid' : '' }}"
                           value="{{ old('invoice_amount') }}" name="invoice_amount"/>
                    <span class="invalid-feedback" role="alert">
							<span class="messages"><strong>{{ $errors->first('invoice_amount') }}</strong></span>
						</span>
                </div>

                <div class="form-group col-md-6">
                    <label for="receive_date">Receive Date :</label>
                    <input type=""
                           class="form-control datepicker {{ $errors->has('receive_date') ? ' is-invalid' : '' }}"
                           value="{{ old('receive_date') }}" name="receive_date"/>
                    @if ( $errors->has('receive_date') )
                        <span class="invalid-feedback" role="alert">
                                <span class="messages"><strong>{{ $errors->first('receive_date') }}</strong></span>
                            </span>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label for="amount"> Receive Amount : </label>
                    <input type="number" step="0.01"
                           class="form-control  {{ $errors->has('receive_amount') ? ' is-invalid' : '' }}"
                           value="{{ old('receive_amount') }}" name="receive_amount"/>
                    <span class="invalid-feedback" role="alert">
							<span class="messages"><strong>{{ $errors->first('receive_amount') }}</strong></span>
						</span>
                </div>

            </div>

            <div class="row">


                <div class="form-group col-md-12">
                    <label for="description">Description :</label>
                    <textarea class="form-control" value="{{ old('description') }}" name="description"></textarea>
                    <p style="color: darkred">Maximum 350 characters</p>
                    @if ( $errors->has('description') )
                        <span class="invalid-feedback" role="alert">
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
<script>


</script>
