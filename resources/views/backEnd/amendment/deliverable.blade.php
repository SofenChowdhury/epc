@extends('backEnd.master')
@section('mainContent')
    <div class="card">
        <div class="card-header">
            <h5>Add Deliverable for Project : {{ $project->project_name}} </h5>
        </div>
        <div class="card-block">
            {{ Form::open(['class' => '', 'files' => true, 'url' => 'project_deliverable', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
            @csrf
            @if(isset($project))
                <div class="row">
                    <div >
                        <input type="text" hidden name="project_id" value="{{ $project->id }}">
                    </div>
                </div>
            @endif

            <input type="hidden" name="amendment" value="{{$maxAmendmentDeliverable+1}}">
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="title"><strong>Amendment No:</strong></label>
                    <input type="text" class="form-control {{ $errors->has('amendment') ? ' is-invalid' : '' }}"
                           value="{{$maxAmendmentDeliverable+1}}"  disabled/>
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
                    <label for="report_name"><span class="important">*</span> Deliverable Name : </label>
                    <input type="text" class="form-control  {{ $errors->has('report_name') ? ' is-invalid' : '' }}" value="{{ old('report_name') }}" name="report_name" />
                    {{--                    <select class="js-example-basic-single col-sm-12 {{ $errors->has('report_name') ? ' is-invalid' : '' }}" name="report_name" id="report_name">--}}
                    {{--                        <option value="">Select Deliverable Name </option>--}}
                    {{--                        @if($reports)--}}
                    {{--                            @foreach($reports as $report)--}}
                    {{--                                <option value="{{ $report->id }}" {{ old('report_name')== $report->id ? 'selected' : old('report_name') }} >{{ $report->report_name }}</option>--}}
                    {{--                            @endforeach--}}
                    {{--                        @endif--}}
                    {{--                    </select>--}}
                    <p style="color: darkred">Maximum 150 characters</p>
                    @if ( $errors->has('report_name') )
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('report_name') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="amount_percentage">Amount Percentage :</label>
                    <input type="text" class="form-control  {{ $errors->has('amount_percentage') ? ' is-invalid' : '' }}" value="{{ old('amount_percentage') }}" name="amount_percentage" />
                    @if ( $errors->has('amount_percentage') )
                        <span class="invalid-feedback" role="alert" >
                                <span class="messages"><strong>{{ $errors->first('amount_percentage') }}</strong></span>
                            </span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="invoice_date">Invoice Sent Date :</label>
                    <input type="" class="form-control datepicker {{ $errors->has('invoice_date') ? ' is-invalid' : '' }}" value="{{ old('invoice_date') }}" name="invoice_date"/>
                    @if ($errors->has('invoice_date'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('invoice_date') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-3">
                    <label for="turnaround_days">Payment Turnaround Days :</label>
                    <input type="" class="form-control {{ $errors->has('turnaround_days') ? ' is-invalid' : '' }}" value="{{ old('turnaround_days') }}" name="turnaround_days"/>
                    @if ($errors->has('turnaround_days'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('turnaround_days') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-3">
                    <label for="interest_rate">Interest Rate :</label>
                    <input type="number" step="0.01" class="form-control  {{ $errors->has('interest_rate') ? ' is-invalid' : '' }}" value="{{ old('interest_rate') }}" name="interest_rate" />
                    @if ( $errors->has('interest_rate') )
                        <span class="invalid-feedback" role="alert" >
                                <span class="messages"><strong>{{ $errors->first('interest_rate') }}</strong></span>
                            </span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="receive_date">Payment Receive Date :</label>
                    <input type="" class="form-control datepicker {{ $errors->has('receive_date') ? ' is-invalid' : '' }}" value="{{ old('receive_date') }}" name="receive_date"/>
                    @if ($errors->has('receive_date'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('receive_date') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="amount_received"> Amount Received:</label>
                    <input type="text" class="form-control  {{ $errors->has('amount_received') ? ' is-invalid' : '' }}" value="{{ old('amount_received') }}" name="amount_received" />
                    @if ( $errors->has('amount_received') )
                        <span class="invalid-feedback" role="alert" >
                                <span class="messages"><strong>{{ $errors->first('amount_received') }}</strong></span>
                            </span>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="description">Description :</label>
                    <textarea class="form-control" name="description">{{ old('description') }}</textarea>
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
