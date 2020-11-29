@extends('backEnd.master')
@section('mainContent')
<div class="card">
	<div class="card-header">
		<h5>Edit Client</h5>
	</div>
	<div class="card-block">
		{{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'client/'.$client->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}

	        <div class="row">
				<div class="form-group col-md-6"></div>

				<div class="form-group col-md-6">
				  	@if( isset($client->client_image) )
						<img src="{{ asset($client->client_image) }}" class="image_center img-radius" height="200px" width="200px" />
					@else
						<img src="{{ asset('/public/images/no_image.png') }}" class="image_center img-radius" height="200px" width="200px" />
					@endif
				</div>
			</div>

	        <div class="row">
                <div class="form-group col-md-6">
                    <label for="client_name">Client Full Name </label>
                    <input type="text" class="form-control {{ $errors->has('client_name') ? ' is-invalid' : '' }}" value="{{$client->client_name }}" name="client_name"/>
                    <p style="color: darkred">Maximum 150 characters</p>
                    @if ($errors->has('client_name'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('client_name') }}</strong></span>
						</span>
                    @endif
                </div>

	        	<div class="form-group col-md-6">
	            	<label for="abbreviation">Client Abbreviation:</label>
	            	<input type="text" class="form-control {{ $errors->has('abbreviation') ? ' is-invalid' : '' }}" name="abbreviation" value="{{ $client->abbreviation }}" />
                    <p style="color: darkred">Maximum 50 characters</p>
                    @if ($errors->has('abbreviation'))
					    <span class="invalid-feedback" role="alert">
							<span class="messages"><strong>{{ $errors->first('abbreviation') }}</strong></span>
						</span>
					@endif
	          	</div>

                <div class="form-group col-md-6">
                    <label for="ministry">Ministry:</label>
                    <input type="ministry" class="form-control {{ $errors->has('ministry') ? ' is-invalid' : '' }}" name="ministry" value="{{ $client->ministry }}"/>
                    <p style="color: darkred">Maximum 100 characters</p>
                    @if ($errors->has('ministry'))
                        <span class="invalid-feedback" role="alert">
							<span class="messages"><strong>{{ $errors->first('ministry') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="division">Division </label>
                    <input type="text" class="form-control" value="{{ $client->division }}" name="division"/>
                    <p style="color: darkred">Maximum 100 characters</p>
                    @if ($errors->has('division'))
                        <span class="invalid-feedback" role="alert">
							<span class="messages"><strong>{{ $errors->first('division') }}</strong></span>
						</span>
                    @endif</div>

                <div class="form-group col-md-6">
                    <label for="agency">Agency </label>
                    <input type="text" class="form-control" value="{{ $client->agency }}" name="agency"/>
                    <p style="color: darkred">Maximum 100 characters</p>
                    @if ($errors->has('agency'))
                        <span class="invalid-feedback" role="alert">
							<span class="messages"><strong>{{ $errors->first('agency') }}</strong></span>
						</span>
                    @endif</div>

                <div class="form-group col-md-6">
                    <label for="website">Company website:</label>
                    <input type="website" class="form-control {{ $errors->has('website') ? ' is-invalid' : '' }}" name="website" value="{{ $client->website }}"/>
                    <p style="color: darkred">Maximum 100 characters</p>
                    @if ($errors->has('website'))
                        <span class="invalid-feedback" role="alert">
							<span class="messages"><strong>{{ $errors->first('website') }}</strong></span>
						</span>
                    @endif
                </div>

			    <div class="form-group col-md-6">
				  	<label for="client_image">Client Logo :</label><br>
				  	<input class="form-control" name="client_image" type="file" id="client_image">
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
					<button type="submit" class="btn btn-primary m-b-0">Update</button>
				</div>
			</div>
		{{ Form::close()}}
	</div>
</div>

@endSection
