@extends('backEnd.master')
@section('mainContent')
<div class="card">
	<div class="card-header">
		<h5>Add Client</h5>
	</div>
	<div class="card-block">
		{{ Form::open(['class' => '', 'files' => true, 'action' => 'ErpClientController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}

		 	@csrf
		 	<div class="row">
		 	  	<div class="form-group col-md-6">
	             	<label for="client_name"><span class="important">*</span> Client Full Name </label>
	             	<input type="text" class="form-control {{ $errors->has('client_name') ? ' is-invalid' : '' }}" value="{{ old('client_name') }}" name="client_name"/>
                    <p style="color: darkred">Maximum 150 characters</p>
                    @if ($errors->has('client_name'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('client_name') }}</strong></span>
						</span>
					@endif
	          	</div>

                <div class="form-group col-md-6">
                    <label for="abbreviation">Client Abbreviation</label>
                    <input type="text" class="form-control {{ $errors->has('abbreviation') ? ' is-invalid' : '' }}" value="{{ old('abbreviation') }}" name="abbreviation"/>
                    <p style="color: darkred">Maximum 50 characters</p>
                    @if ($errors->has('abbreviation'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('abbreviation') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="ministry"> Ministry </label>
                    <input type="ministry" class="form-control {{ $errors->has('ministry') ? ' is-invalid' : '' }}" value="{{ old('ministry') }}" name="ministry"/>
                    <p style="color: darkred">Maximum 100 characters</p>
                    @if ($errors->has('ministry'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('ministry') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="division">Division </label>
                    <input type="text" class="form-control" value="{{ old('division') }}" name="division"/>
                    <p style="color: darkred">Maximum 100 characters</p>
                    @if ($errors->has('division'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('division') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="agency">Agency </label>
                    <input type="text" class="form-control" value="{{ old('agency') }}" name="agency"/>
                    <p style="color: darkred">Maximum 100 characters</p>
                    @if ($errors->has('agency'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('agency') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="website">Company website </label>
                    <input type="text" class="form-control" value="{{ old('website') }}" name="website"/>
                    <p style="color: darkred">Maximum 100 characters</p>
                    @if ($errors->has('website'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('website') }}</strong></span>
						</span>
                    @endif
                </div>

			    <div class="form-group col-md-6">
				  	<label for="client_image">Company Logo </label><br>
				  	<input data-preview="#preview" class="form-control" name="client_image" type="file" id="client_image">
        			<img class="col-sm-6" id="preview"  src="">
				  	@if ($errors->has('client_image'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('client_image') }}</strong></span>
						</span>
					@endif
				</div>
            </div>

			<div class="form-group row mt-4">
				<div class="col-sm-6 text-center" style="margin-bottom: 1em;">
					<a class="" title="Back" href="{{url('/client')}}">
						<button type="button" class="btn btn-primary m-b-0">Back</button>
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
