@extends('backEnd.master')
@section('mainContent')
    <div class="card">
        <div class="card-header">
            <h5>Add Reporting for Project : {{ $project->project_name}} </h5>
        </div>
        <div class="card-block">
            {{ Form::open(['class' => '', 'files' => true, 'url' => 'project_reporting', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
            @csrf
            @if(isset($project))
                <div class="row">
                    <div >
                        <input type="text" hidden name="project_id" value="{{ $project->id }}">
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="employee"><strong> Amendment No:</strong></label>
                    <select
                        class="js-example-basic-single col-sm-12 {{ $errors->has('amendment') ? ' is-invalid' : '' }}"
                        name="amendment" id="amendment">
                        <option value="">Select Amendment No</option>
                        @if(isset($maxAmendmentReporting))
                            @for($y=1; $y<=$maxAmendmentReporting; $y++)
                                <option
                                    value="{{ $y}}">{{$y}}</option>
                            @endfor
                        @endif
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="report_name"><span class="important">*</span> Report Name :</label>
                    <input type="text" class="form-control  {{ $errors->has('report_name') ? ' is-invalid' : '' }}" value="{{ old('report_name') }}" name="report_name" />
                    <p style="color: darkred">Maximum 150 characters</p>
                    @if ( $errors->has('report_name') )
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('report_name') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="no_of_copies">Number of copies :</label>
                    <input type="text" class="form-control  {{ $errors->has('no_of_copies') ? ' is-invalid' : '' }}" value="{{ old('no_of_copies') }}" name="no_of_copies" />
                    @if ( $errors->has('no_of_copies') )
                        <span class="invalid-feedback" role="alert" >
                                <span class="messages"><strong>{{ $errors->first('no_of_copies') }}</strong></span>
                            </span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="due_date">Due Date :</label>
                    <input type="" class="form-control datepicker {{ $errors->has('due_date') ? ' is-invalid' : '' }}" value="{{ old('due_date') }}" name="due_date"/>
                    @if ($errors->has('due_date'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('due_date') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="submitted_on">Submission Date :</label>
                    <input type="" class="form-control datepicker {{ $errors->has('submitted_on') ? ' is-invalid' : '' }}" value="{{ old('submitted_on') }}" name="submitted_on"/>
                    @if ($errors->has('submitted_on'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('submitted_on') }}</strong></span>
						</span>
                    @endif
                </div>
            </div>

            <div class="row">
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
