@extends('backEnd.master')
@section('mainContent')
<div class="card">
	<div class="card-header">
		<h5>Create Joint Venture Party</h5>
	</div>
	<div class="card-block">
		@if(isset($editData))
        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'project/updateJV/'.$editData->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
        @else
        {{ Form::open(['class' => '', 'files' => true, 'url' => 'project/storeJV/'.$project->id, 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
        @endif

		 	@csrf
		 	<div class="row">
		 	  	<div class="form-group col-md-6">
	             	<label for="jv_name"><span class="important">*</span> Joint Venture Name </label>
	             	<input type="text" class="form-control {{ $errors->has('jv_name') ? ' is-invalid' : '' }}" value="{{ isset($editData)? $editData->jv_name : old('jv_name') }}" name="jv_name"/>
                    <p style="color: darkred">Maximum 150 characters</p>
                    @if ($errors->has('jv_name'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('jv_name') }}</strong></span>
						</span>
					@endif
	          	</div>

	          	<div class="form-group col-md-3">
					<label for="jv_leading"><span class="important">*</span> Lead :</label>
				  	<select class="js-example-basic-single col-sm-12 {{ $errors->has('jv_leading') ? ' is-invalid' : '' }}" name="jv_leading" id="jv_leading" required>
				  		<option value="0"
	                        @if(isset($editData))
	                            @if($editData->jv_leading == 0) selected @endif
	                        @endif>
	                        None
	                    </option>
	                    <option value="1"
	                        @if(isset($editData))
	                            @if($editData->jv_leading == 1) selected @endif
	                        @endif>
	                        Local Lead
	                    </option>
	                    <option value="2"
	                        @if(isset($editData))
	                            @if($editData->jv_leading == 2) selected @endif
	                        @endif>
	                        International Lead
	                    </option>
					</select>
					@if ($errors->has('jv_leading'))
					<span class="invalid-feedback invalid-select" role="alert">
						<strong class="messages">{{ $errors->first('jv_leading') }}</strong>
					</span>
					@endif
				</div>

                <div class="form-group col-md-3">
                    <label for="share_percentage"><span class="important">*</span> Share Percentage (%) </label>
                    <input type="text" class="form-control {{ $errors->has('share_percentage') ? ' is-invalid' : '' }}" value="{{ isset($editData)? $editData->share_percentage : old('share_percentage') }}" name="share_percentage"/>
                    @if ($errors->has('share_percentage'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('share_percentage') }}</strong></span>
						</span>
                    @endif
                </div>
		 	</div>

          	<div class="row">
				<div class="form-group col-md-6">
					<label for="contact_person"><span class="important">*</span> Contact Person</label>
					<input type="text" class="form-control {{ $errors->has('contact_person') ? ' is-invalid' : '' }}" value="{{ isset($editData)? $editData->contact_person : old('contact_person') }}" name="contact_person"/>
					@if ($errors->has('contact_person'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('contact_person') }}</strong></span>
						</span>
					@endif
				</div>

				<div class="form-group col-md-6">
					<label for="designation"> Designation  </label>
					<input type="text" class="form-control {{ $errors->has('designation') ? ' is-invalid' : '' }}" value="{{  isset($editData) ? $editData->designation : old('designation') }}" name="designation"/>
					@if ($errors->has('designation'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('designation') }}</strong></span>
						</span>
					@endif
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-6">
					<label for="email"> Email </label>
					<input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ isset($editData) ? $editData->email : old('email') }}" name="email"/>
					@if ($errors->has('email'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('email') }}</strong></span>
						</span>
					@endif
				</div>

				<div class="form-group col-md-6">
					<label for="phone_number"> Phone Number </label>
					<input type="" class="form-control {{ $errors->has('phone_number') ? ' is-invalid' : '' }}" value="{{ isset($editData)? $editData->phone_number : old('phone_number') }}" name="phone_number"/>
					@if ($errors->has('phone_number'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('phone_number') }}</strong></span>
						</span>
					@endif
				</div>
      		</div>

          	<div class="row">
				<div class="form-group col-md-6">
				 	<label for="address">Address</label>
				 	<textarea class="form-control" name="address">{{ isset($editData)? $editData->address : old('address') }}</textarea>
                    <p style="color: darkred">Maximum 350 characters</p>
                </div>

			    <div class="form-group col-md-6">
				 	<label for="remarks">Remarks </label>
				 	<textarea class="form-control" name="remarks">{{ isset($editData)? $editData->remarks : old('remarks') }}</textarea>
                    <p style="color: darkred">Maximum 350 characters</p>
                </div>
          	</div>

			<div class="form-group row mt-4">
				<div class="col-sm-6 text-center" style="margin-bottom: 1em;">
					@if(isset($editData))
					<a class="" title="Back" href="{{ route('project.show',$editData->project_id) }}">
					@else
					<a class="" title="Back" href="{{ route('project.show',$project->id) }}">
					@endif
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
