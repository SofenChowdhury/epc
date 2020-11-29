@extends('backEnd.master')
@section('mainContent')

<div class="card">

	{{ Form::open(['class' => '', 'files' => true, 'url' => 'employee', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'on']) }}

		<!-- 1. PERSONAL INFORMATIONS -->
		<div class="card-header">
			<h5>Personal Information</h5>
		</div>

		<div class="card-block">

			<!-- ROW 1 : FIRST NAME, LAST NAME-->
			<div class="row">
				<div class="form-group col-md-6">
				  	<label for="first_name"><span class="important">*</span> First Name:</label>
				  	<input type="text" class="form-control  {{ $errors->has('first_name') ? ' is-invalid' : '' }}" value="{{ old('first_name') }}" name="first_name" />
				  	@if ($errors->has('first_name'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('first_name') }}</strong></span>
						</span>
					@endif
				</div>
				<div class="form-group col-md-6">
				  	<label for="last_name"><span class="important">*</span> Last Name:</label>
				  	<input type="text" class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}" value="{{ old('last_name') }}" name="last_name"/>
				  	@if ($errors->has('last_name'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('last_name') }}</strong></span>
						</span>
					@endif
				</div>
			</div>

			<!-- ROW 2 : EMAIL, DOB, JOINING DATE -->
			<div class="row">
                <div class="form-group col-md-3">
                    <label for="unique_id"><span class="important">*</span> Employee ID:</label>
                    <input type="text" class="form-control {{ $errors->has('unique_id') ? ' is-invalid' : '' }}" value="{{ old('unique_id') }}" name="unique_id"/>
                    @if ($errors->has('unique_id'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('unique_id') }}</strong></span>
						</span>
                    @endif
                </div>

				<div class="form-group col-md-3">
				  	<label for="email"><span class="important">*</span> Email:</label>
				  	<input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" name="email"/>
				  	@if ($errors->has('email'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('email') }}</strong></span>
						</span>
					@endif
				</div>
				<div class="form-group col-md-3">
				  	<label for="date_of_birth"><span class="important">*</span> Date of Birth:</label>
				  	<input type="" class="form-control datepicker {{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}" value="{{ old('date_of_birth') }}" name="date_of_birth"/>
				  	@if ($errors->has('date_of_birth'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('date_of_birth') }}</strong></span>
						</span>
					@endif
				</div>
				<div class="form-group col-md-3">
				  	<label for="joining_date"><span class="important">*</span> Joining Date:</label>
				  	<input type="" class="form-control datepicker {{ $errors->has('joining_date') ? ' is-invalid' : '' }}" value="{{ old('joining_date') }}" name="joining_date" autocomplete="off"/>
				  	@if ($errors->has('joining_date'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('joining_date') }}</strong></span>
						</span>
					@endif
				</div>
			</div>

			<!-- ROW 3 : CELL NO, EMERGENCY NO, EMPLOYEE TYPE, EMPLOYEE CATEGORY -->
			<div class="row">
				<div class="form-group col-md-3">
				  <label for="mobile"><span class="important">*</span> Contact no:</label>
				  <input type="text" class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}" value="{{ old('mobile') }}" name="mobile"/>
				  	@if ($errors->has('mobile'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('mobile') }}</strong></span>
						</span>
					@endif
				</div>
				<div class="form-group col-md-3">
				  	<label for="emergency_no">Emergency No:</label>
				  	<input type="text" class="form-control {{ $errors->has('emergency_no') ? ' is-invalid' : '' }}" value="{{ old('emergency_no') }}" name="emergency_no"/>
				  	@if ($errors->has('emergency_no'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('emergency_no') }}</strong></span>
						</span>
					@endif
				</div>
				<div class="form-group col-md-3">
				  	<label for="employee_type"><span class="important">*</span> Employee Type:</label>
				  	<select class="js-example-basic-single col-sm-12 {{ $errors->has('employee_type') ? ' is-invalid' : '' }}" name="employee_type" id="employee_type">
{{--						<option value="">Select Employee Type</option>--}}
						@if(isset($types))
							@foreach($types as $type)
								<option value="{{ $type->id }}" {{ old('employee_type')== $type->id ? 'selected' : old('employee_type')  }} >{{$type->type_name}}</option>
							@endforeach
						@endif
					</select>
					@if ($errors->has('employee_type'))
					<span class="invalid-feedback invalid-select" role="alert">
						<strong>{{ $errors->first('employee_type') }}</strong>
					</span>
					@endif
				</div>
				<div class="form-group col-md-3">
				  	<label for="employee_category"><span class="important">*</span> Employee Category:</label>
				  	<select class="js-example-basic-single col-sm-12 {{ $errors->has('employee_category') ? ' is-invalid' : '' }}" name="employee_category" id="employee_category">
						<option value="">Select Employee Category</option>
						@if(isset($employee_categories))
							@foreach($employee_categories as $category)
								<option value="{{ $category->id }}" {{ old('employee_category')== $category->id ? 'selected' : old('employee_category')  }} >{{$category->category_name}}</option>
							@endforeach
						@endif
					</select>
					@if ($errors->has('employee_category'))
					<span class="invalid-feedback invalid-select" role="alert">
						<strong>{{ $errors->first('employee_category') }}</strong>
					</span>
					@endif
				</div>
			</div>

			<!-- ROW 4 : PROBATION PERIOD, JOINING LETTER, EMP IMAGE -->
			<div class="row">
				<div class="form-group col-md-6">
				  	<label for="probation_period">Probation Period End Date:</label>
				  	<input type="" class="form-control datepicker {{ $errors->has('probation_period') ? ' is-invalid' : '' }}" value="{{ old('probation_period') }}" name="probation_period"/>
				  	@if ($errors->has('probation_period'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('probation_period') }}</strong></span>
						</span>
					@endif
				</div>
				<div class="form-group col-md-3">
				  	<label for="joining_letter">Joining Letter:</label><br>
				  	<input data-preview="#preview" class="form-control" name="joining_letter" type="file" id="joining_letter">
	    			<p> <strong> Please choose a .pdf file </strong> </p>
				  	@if ($errors->has('joining_letter'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('joining_letter') }}</strong></span>
						</span>
					@endif
				</div>
				<div class="form-group col-md-3">
				  	<label for="employee_photo">Employee Image:</label><br>
				  	<input data-preview="#preview" class="form-control" name="employee_photo" type="file" id="employee_photo">
	    			<p> <strong> Please choose a .jpg or .jpeg file </strong> </p>
				  	@if ($errors->has('employee_photo'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('employee_photo') }}</strong></span>
						</span>
					@endif
				</div>
			</div>

			<!-- ROW 5 : PLACE OF BIRTH, NID, TIN -->
			<div class="row">
				<div class="form-group col-md-6">
				  	<label for="place_of_birth"><span class="important">*</span> Place of Birth:</label>
				  	<input type="text" class="form-control {{ $errors->has('place_of_birth') ? ' is-invalid' : '' }}" value="{{ old('place_of_birth') }}" name="place_of_birth"/>
				  	@if ($errors->has('place_of_birth'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('place_of_birth') }}</strong></span>
						</span>
					@endif
				</div>
				<div class="form-group col-md-3">
				  <label for="nid"><span class="important">*</span> National Identification No:</label>
				  <input type="text" class="form-control {{ $errors->has('nid') ? ' is-invalid' : '' }}" value="{{ old('nid') }}" name="nid"/>
				  	@if ($errors->has('nid'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('nid') }}</strong></span>
						</span>
					@endif
				</div>
				<div class="form-group col-md-3">
				  	<label for="tin"><span class="important">*</span> Tax Identification No (TIN):</label>
				  	<input type="text" class="form-control {{ $errors->has('tin') ? ' is-invalid' : '' }}" value="{{ old('tin') }}" name="tin"/>
				  	@if ($errors->has('tin'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('tin') }}</strong></span>
						</span>
					@endif
				</div>
			</div>

			<!-- ROW 6 : DEPARTMENT, DESIGNATION, GENDER, BLOOD GROUP -->
			<div class="row">
				<div class="form-group col-md-3" id="first-choice">
				  	<label for="department_id"><span class="important">*</span> Department name:</label>
				  	<select class="js-example-basic-single col-sm-12 {{ $errors->has('department_id') ? ' is-invalid' : '' }}" name="department_id" id="department_id">
						<option value="">Select Department</option>
						@if(isset($departments))
							@foreach($departments as $department)
								<option value="{{ $department->id }}" {{ old('department_id')== $department->id ? 'selected' : old('department_id')  }} >{{$department->department_name}}</option>
							@endforeach
						@endif
					</select>
					@if ($errors->has('department_id'))
					<span class="invalid-feedback invalid-select" role="alert">
						<strong>{{ $errors->first('department_id') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group col-md-3">
					<label for="designation_id"><span class="important">*</span> Designation name:</label>
				  	<select class="js-example-basic-single col-sm-12 {{ $errors->has('designation_id') ? ' is-invalid' : '' }}" name="designation_id" id="designation_id">
						<option value="">Select Designation</option>
						@if(isset($designations))
							@foreach($designations as $designation)
								<option value="{{ $designation->id }}" {{ old('designation_id')== $designation->id ? 'selected' : old('designation_id')  }} >{{$designation->designation_name}}</option>
							@endforeach
						@endif
					</select>
					@if ($errors->has('designation_id'))
					<span class="invalid-feedback invalid-select" role="alert">
						<strong>{{ $errors->first('designation_id') }}</strong>
					</span>
					@endif
				</div>

                <div class="form-group col-md-6">
                    <label for="supervisor_designation">Reporting Supervisor Designation:</label>
                    <select class="js-example-basic-single col-sm-12 {{ $errors->has('supervisor_designation') ? ' is-invalid' : '' }}" name="supervisor_designation" id="supervisor_designation">
                        <option value="">Select Designation</option>
                        @if(isset($designations))
                            @foreach($designations as $designation)
                                <option value="{{ $designation->id }}" {{ old('supervisor_designation')== $designation->id ? 'selected' : old('supervisor_designation')  }} >{{$designation->designation_name}}</option>
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->has('supervisor_designation'))
                        <span class="invalid-feedback invalid-select" role="alert">
						<strong>{{ $errors->first('supervisor_designation') }}</strong>
					</span>
                    @endif
                </div>
			</div>

            <div class="row">
                <div class="form-group col-md-3">
                    <label for="location">Location</label>
                    <select class="js-example-basic-single col-sm-12 {{ $errors->has('location') ? ' is-invalid' : '' }}" name="location" id="location">
                        <option value="">Select Location</option>
                        <option value="0" {{ old('location') == 0 ? 'selected' : '' }}>Head Office</option>
                        @if(isset($projects))
                            @foreach($projects as $project)
                                <option value="{{$project->id}}" {{ old('location') == $project->id ? 'selected' : '' }}>{{$project->project_name}}</option>
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->has('location'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('location') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-3">
                    <label for="room_no">Room Number</label>
                    <select class="js-example-basic-single col-sm-12 {{ $errors->has('room_no') ? ' is-invalid' : '' }}" name="room_no" id="room_no">
                        <option value="">Select Room Number</option>
                        @if(isset($rooms))
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_no')== $room->id ? 'selected' : old('room_no')  }} >{{$room->room_no}}</option>
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->has('room_no'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('room_no') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-3">
                    <label for="gender_id"><span class="important">*</span> Gender:</label>
                    <select class="js-example-basic-single col-sm-12 {{ $errors->has('gender_id') ? ' is-invalid' : '' }}" name="gender_id" id="gender_id">
                        <option value="">Select gender</option>
                        @if(isset($genders))
                            @foreach($genders as $gender)
                                <option value="{{ $gender->id }}" {{ old('gender_id')== $gender->id ? 'selected' : old('gender_id')  }} >{{$gender->base_setup_name}}</option>
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->has('gender_id'))
                        <span class="invalid-feedback invalid-select" role="alert">
						<strong>{{ $errors->first('gender_id') }}</strong>
					</span>
                    @endif
                </div>

                <div class="form-group col-md-3">
                    <label for="blood_group_id"><span class="important">*</span> Blood group:</label>
                    <select class="js-example-basic-single col-sm-12 {{ $errors->has('blood_group_id') ? ' is-invalid' : '' }}" name="blood_group_id" id="blood_group_id">
                        <option value="">Select group</option>
                        @if(isset($blood_groups))
                            @foreach($blood_groups as $blood_group)
                                <option value="{{ $blood_group->id }}" {{ old('blood_group_id')== $blood_group->id ? 'selected' : old('blood_group_id')  }} >{{$blood_group->base_setup_name}}</option>
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->has('blood_group_id'))
                        <span class="invalid-feedback invalid-select" role="alert">
						<strong>{{ $errors->first('blood_group_id') }}</strong>
					</span>
                    @endif
                </div>
            </div>

			<!-- ROW 7 : PERMANENT AND CURRENT ADDRESS -->
			<div class="row">
				<div class="form-group col-md-6">
				  	<label for="current_address"><span class="important">*</span> Current address:</label>
				  	<textarea class="form-control" value="{{ old('current_address') }}" name="current_address">{{ old('current_address') }}</textarea>
                    <p style="color: darkred">Maximum 350 characters</p>
                    @if ($errors->has('current_address'))
					<span class="invalid-feedback invalid-select" role="alert">
						<strong>{{ $errors->first('current_address') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group col-md-6">
				  	<label for="permanent_address">Permanent address:</label>
				  	<textarea class="form-control" value="{{ old('permanent_address') }}" name="permanent_address">{{ old('permanent_address') }}</textarea>
                    <p style="color: darkred">Maximum 350 characters</p>
                    @if ($errors->has('permanent_address'))
					<span class="invalid-feedback invalid-select" role="alert">
						<strong>{{ $errors->first('permanent_address') }}</strong>
					</span>
					@endif
				</div>
			</div>

			<!-- ROW 8 : QUALIFICATIONS, EXPERIENCES -->
			<div class="row">
				<div class="form-group col-md-6">
				  	<label for="qualifications"> Qualifications:</label>
				  	<textarea class="form-control" name="qualifications">{{ old('qualifications') }}</textarea>
                    <p style="color: darkred">Maximum 350 characters</p>
                    @if ($errors->has('qualifications'))
					<span class="invalid-feedback invalid-select" role="alert">
						<strong>{{ $errors->first('qualifications') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group col-md-6">
				  	<label for="experiences">Experiences:</label>
				  	<textarea class="form-control" name="experiences">{{ old('experiences') }}</textarea>
                    <p style="color: darkred">Maximum 350 characters</p>
                    @if ($errors->has('experiences'))
					<span class="invalid-feedback invalid-select" role="alert">
						<strong>{{ $errors->first('experiences') }}</strong>
					</span>
					@endif
				</div>
			</div>

			<!-- ROW 9 : DOCUMENTS - QUALIFICATIONS, EXPERIENCES -->

			<div class="row">
				<div class="form-group col-md-6">
				  	<label for="qualification_docs">Qualification Documents (Degree / Certificate):</label><br>
				  	<input class="form-control" name="qualification_docs[]" type="file" multiple="multiple">
	    			<p> <strong> You can choose multiple .pdf files </strong> </p>
				  	@if ($errors->has('qualification_docs'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('qualification_docs') }}</strong></span>
						</span>
					@endif
				</div>

				<div class="form-group col-md-6">
				  	<label for="experience_docs">Work Experience Documents (CV):</label><br>
				  	<input class="form-control" name="experience_docs[]" type="file" multiple="multiple">
	    			<p> <strong> You can choose multiple .pdf files </strong> </p>
				  	@if ($errors->has('experience_docs'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('experience_docs') }}</strong></span>
						</span>
					@endif
				</div>
			</div>

			<!-- ROW 10 : OTHER YES/NO INFO -->
			<div class="row">
				<div class="form-group col-md-2">
					<label></label>
					<label>Previous Employment with EPC? If yes, then when?</label>
				</div>
				<div class="form-group col-md-1">
				    <label for="epc_before"><span class="important">*</span> Yes / No</label>
				    <select class="js-example-basic-single col-sm-12 {{ $errors->has('epc_before') ? ' is-invalid' : '' }}" name="epc_before" id="epc_before">
						<!-- <option value="">Select</option> -->
						<option value="1" {{ old('epc_before') == 1 ? 'selected' : '' }}>Yes</option>
						<option value="0" {{ old('epc_before') == 0 ? 'selected' : '' }}>No</option>
					</select>
					@if ($errors->has('epc_before'))
					<span class="invalid-feedback invalid-select" role="alert">
						<strong>{{ $errors->first('epc_before') }}</strong>
					</span>
					@endif
				</div>
				<div class="form-group col-md-3 row">
                    <div class="col-md-6">
                        <label for="epc_before_from">From:</label>
                        <input type="" class="form-control datepicker {{ $errors->has('epc_before_from') ? ' is-invalid' : '' }}" value="{{ old('epc_before_from') }}" name="epc_before_from"/>
                        @if ($errors->has('epc_before_from'))
                            <span class="invalid-feedback" role="alert" >
                                <span class="messages"><strong>{{ $errors->first('epc_before_from') }}</strong></span>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label for="epc_before_to">To:</label>
                        <input type="" class="form-control datepicker {{ $errors->has('epc_before_to') ? ' is-invalid' : '' }}" value="{{ old('epc_before_to') }}" name="epc_before_to"/>
                        @if ($errors->has('epc_before_to'))
                            <span class="invalid-feedback" role="alert" >
                                <span class="messages"><strong>{{ $errors->first('epc_before_to') }}</strong></span>
                            </span>
                        @endif
                    </div>
				</div>

				<div class="form-group col-md-2">
					<label></label>
					<label>Relatives or acquaintances working for EPC?</label>
				</div>
				<div class="form-group col-md-1">
				    <label for="relative"><span class="important">*</span> Yes / No</label>
				    <select class="js-example-basic-single col-sm-12 {{ $errors->has('relative') ? ' is-invalid' : '' }}" name="relative" id="relative">
						<!-- <option value="">Select</option> -->
						<option value="1" {{ old('relative') == 1 ? 'selected' : '' }}>Yes</option>
						<option value="0" {{ old('relative') == 0 ? 'selected' : '' }}>No</option>
					</select>
					@if ($errors->has('relative'))
					<span class="invalid-feedback invalid-select" role="alert">
						<strong>{{ $errors->first('relative') }}</strong>
					</span>
					@endif
				</div>
				<div class="form-group col-md-3">
				  	<label for="relative_name">Name and relationship</label>
					<input type="text" class="form-control {{ $errors->has('relative_name') ? ' is-invalid' : '' }}" value="{{ old('relative_name') }}" name="relative_name"/>
				  	@if ($errors->has('relative_name'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('relative_name') }}</strong></span>
						</span>
					@endif
				</div>
			</div>
		</div>
		<hr>

	<!-- FAMILY DETAILS -->
		<div class="card-header">
			<h5>Family Details</h5>
		</div>

		<div class="card-block">
			<!-- FAMILY ROW 1: FATHER'S NAME, MOTHER'S NAME -->
			<div class="row">
				<div class="form-group col-md-6">
				  	<label for="father_name"><span class="important">*</span> Father's Name:</label>
				  	<input type="text" class="form-control  {{ $errors->has('father_name') ? ' is-invalid' : '' }}" value="{{ old('father_name') }}" name="father_name" />
				  	@if ($errors->has('father_name'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('father_name') }}</strong></span>
						</span>
					@endif
				</div>
				<div class="form-group col-md-6">
				  	<label for="mother_name"><span class="important">*</span> Mother's Name:</label>
				  	<input type="text" class="form-control {{ $errors->has('mother_name') ? ' is-invalid' : '' }}" value="{{ old('mother_name') }}" name="mother_name"/>
				  	@if ($errors->has('mother_name'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('mother_name') }}</strong></span>
						</span>
					@endif
				</div>
			</div>

			<!-- FAMILY ROW 2 : MARITAL STATUS, SPOUSE, CHILDREN NAMES -->
			<div class="row">
				<div class="form-group col-md-3">
				  	<label for="marital_status"><span class="important">*</span> Marital Status:</label>
				  	<select class="js-example-basic-single col-sm-12 {{ $errors->has('marital_status') ? ' is-invalid' : '' }}" name="marital_status" id="marital_status">
						<option value="">Select</option>
						<option value="single" {{ old('marital_status') == "single" ? 'selected' : '' }}>Single</option>
						<option value="married" {{ old('marital_status') == "married" ? 'selected' : '' }}>Married</option>
					</select>
					@if ($errors->has('marital_status'))
					<span class="invalid-feedback invalid-select" role="alert">
						<strong>{{ $errors->first('marital_status') }}</strong>
					</span>
					@endif
				</div>
				<div class="form-group col-md-3">
				  	<label for="spouse_name">Spouse Name:</label>
				  	<input type="text" class="form-control {{ $errors->has('spouse_name') ? ' is-invalid' : '' }}" value="{{ old('spouse_name') }}" name="spouse_name"/>
				  	@if ($errors->has('spouse_name'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('spouse_name') }}</strong></span>
						</span>
					@endif
				</div>
				<div class="form-group col-md-6">
				  	<label for="child_name">Child's Name (s):</label>
				  	<input type="text" class="form-control {{ $errors->has('child_name') ? ' is-invalid' : '' }}" value="{{ old('child_name') }}" name="child_name"/>
				  	@if ($errors->has('child_name'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('child_name') }}</strong></span>
						</span>
					@endif
				</div>
			</div>
		</div>
		<hr>

		<!-- BANK DETAILS -->
		<div class="card-header">
			<h5>Bank Details</h5>
		</div>

		<div class="card-block">
			<!-- BANK ROW 1 : BANK NAME, ACCOUNT NUMBER  -->
			<div class="row">
				<div class="form-group col-md-6">
				  	<label for="bank_name">Bank Name:</label>
				  	<input type="text" class="form-control  {{ $errors->has('bank_name') ? ' is-invalid' : '' }}" value="{{ old('bank_name') }}" name="bank_name" autocomplete="on"/>
				  	@if ($errors->has('bank_name'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('bank_name') }}</strong></span>
						</span>
					@endif
				</div>
				<div class="form-group col-md-6">
				  	<label for="account_number">Account Number:</label>
				  	<input type="text" class="form-control {{ $errors->has('account_number') ? ' is-invalid' : '' }}" value="{{ old('account_number') }}" name="account_number" autocomplete="on"/>
				  	@if ($errors->has('account_number'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('account_number') }}</strong></span>
						</span>
					@endif
				</div>
			</div>

			<!-- BANK ROW 2 : BANK BRANCH, BANK ADDRESS -->
			<div class="row">
				<div class="form-group col-md-6">
				  	<label for="bank_branch">Bank Branch:</label>
				  	<input type="text" class="form-control {{ $errors->has('bank_branch') ? ' is-invalid' : '' }}" value="{{ old('bank_branch') }}" name="bank_branch" autocomplete="on"/>
				  	@if ($errors->has('bank_branch'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('bank_branch') }}</strong></span>
						</span>
					@endif
				</div>
				<div class="form-group col-md-6">
				  	<label for="bank_address">Bank Address:</label>
				  	<input type="text" class="form-control {{ $errors->has('bank_address') ? ' is-invalid' : '' }}" value="{{ old('bank_address') }}" name="bank_address" autocomplete="on"/>
				  	@if ($errors->has('bank_address'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('bank_address') }}</strong></span>
						</span>
					@endif
				</div>
			</div>

			<!-- BANK ROW 3 : ROUTING NUMBER, SWIFT KEY, SAVINGS/CHECKING -->
			<div class="row">
				<div class="form-group col-md-3">
				  	<label for="routing_no">Routing Number:</label>
				  	<input type="text" class="form-control {{ $errors->has('routing_no') ? ' is-invalid' : '' }}" value="{{ old('routing_no') }}" name="routing_no" autocomplete="on"/>
				  	@if ($errors->has('routing_no'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('routing_no') }}</strong></span>
						</span>
					@endif
				</div>
				<div class="form-group col-md-3">
				  	<label for="swift_code">Swift Code:</label>
				  	<input type="text" class="form-control {{ $errors->has('swift_code') ? ' is-invalid' : '' }}" value="{{ old('swift_code') }}" name="swift_code" autocomplete="on"/>
				  	@if ($errors->has('swift_code'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('swift_code') }}</strong></span>
						</span>
					@endif
				</div>
				<div class="form-group col-md-3">
				  	<label for="checking_savings">Checking / Savings:</label>
				  	<input type="text" class="form-control {{ $errors->has('checking_savings') ? ' is-invalid' : '' }}" value="{{ old('checking_savings') }}" name="checking_savings" autocomplete="on"/>
				  	@if ($errors->has('checking_savings'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('checking_savings') }}</strong></span>
						</span>
					@endif
				</div>
			</div>
		</div>

		<!-- SALARY DETAILS -->
		<div class="card-header">
			<h5>Salary Details</h5>
		</div>

		<div class="card-block">
			<!-- SALARY ROW 1   -->
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="total_salary">Gross Salary:</label>
                    <input type="number" step="0.01" class="form-control  {{ $errors->has('total_salary') ? ' is-invalid' : '' }}" value="{{ old('total_salary') ? old('total_salary') : 0 }}" name="total_salary" id="total_salary"/>
                    @if ($errors->has('total_salary'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('total_salary') }}</strong></span>
						</span>
                    @endif
                </div>
            </div>

            <!-- SALARY ROW 2  -->
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="basic_percentage">Basic Salary (% of gross salary):</label>
                    <input type="number" step="0.01" class="form-control  {{ $errors->has('basic_percentage') ? ' is-invalid' : '' }}" value="{{ old('basic_percentage') ? old('basic_percentage') : 40 }}" name="basic_percentage" id="basic_percentage"/>
                    @if ($errors->has('basic_percentage'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('basic_percentage') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-3">
                    <label for="basic">Basic Salary Amount:</label>
                    <input type="number" step="0.01" class="form-control  {{ $errors->has('basic') ? ' is-invalid' : '' }}" readonly name="basic" id="basic"/>
                    @if ($errors->has('basic'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('basic') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-3">
                    <label for="medical_percentage">Medical (% of basic salary):</label>
                    <input type="number" step="0.01" class="form-control {{ $errors->has('medical_percentage') ? ' is-invalid' : '' }}" value="{{ old('medical_percentage') ? old('medical_percentage') : 10 }}" name="medical_percentage" id="medical_percentage" readonly/>
                    @if ($errors->has('medical_percentage'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('medical_percentage') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-3">
                    <label for="medical">Medical Amount:</label>
                    <input type="number" step="0.01" class="form-control {{ $errors->has('medical') ? ' is-invalid' : '' }}" readonly name="medical" id="medical"/>
                    @if ($errors->has('medical'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('medical') }}</strong></span>
						</span>
                    @endif
                </div>
            </div>

            <!-- SALARY ROW 3  -->
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="provident_fund_percentage">Provident Fund (% of gross salary):</label>
                    <input type="number" step="0.01" class="form-control {{ $errors->has('provident_fund_percentage') ? ' is-invalid' : '' }}" value="{{ old('provident_fund_percentage') ? old('provident_fund_percentage') : 0 }}" name="provident_fund_percentage" id="provident_fund_percentage"/>
                    @if ($errors->has('provident_fund_percentage'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('provident_fund_percentage') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-3">
                    <label for="provident_fund">Provident Fund Amount:</label>
                    <input type="number" step="0.01" class="form-control {{ $errors->has('provident_fund') ? ' is-invalid' : '' }}" readonly name="provident_fund" id="provident_fund"/>
                    @if ($errors->has('provident_fund'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('provident_fund') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-3">
                    <label for="conveyance">Conveyance:</label>
                    <input type="number" step="0.01" class="form-control {{ $errors->has('conveyance') ? ' is-invalid' : '' }}" value="{{ old('conveyance') ? old('conveyance') : 2500 }}" name="conveyance" id="conveyance" readonly/>
                    @if ($errors->has('conveyance'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('conveyance') }}</strong></span>
						</span>
                    @endif
                </div>

            </div>

            <!-- SALARY ROW 3  -->
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="yearly_income">Yearly Taxable Income:</label>
                    <input type="number" class="form-control {{ $errors->has('yearly_income') ? ' is-invalid' : '' }}" readonly name="yearly_income" id="yearly_income"/>
                    @if ($errors->has('yearly_income'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('yearly_income') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-3">
                    <label for="yearly_tax">Yearly Tax Payable:</label>
                    <input type="number" class="form-control {{ $errors->has('yearly_tax') ? ' is-invalid' : '' }}" readonly name="yearly_tax" id="yearly_tax"/>
                    @if ($errors->has('yearly_tax'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('yearly_tax') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-3">
                    <label for="tax_amount">Monthly Tax Payable:</label>
                    <input type="number" class="form-control {{ $errors->has('tax_amount') ? ' is-invalid' : '' }}" readonly name="tax_amount" id="tax_amount"/>
                    @if ($errors->has('tax_amount'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('tax_amount') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-3">
                    <label for="tax_payable">Monthly TDS (80%):</label>
                    <input type="number" class="form-control {{ $errors->has('tax_payable') ? ' is-invalid' : '' }}" readonly name="tax_payable" id="tax_payable"/>
                    @if ($errors->has('tax_payable'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('tax_payable') }}</strong></span>
						</span>
                    @endif
                </div>
			</div>
		</div>

		<!-- SUBMIT BUTTON -->
		<div class="form-group row mt-5">
			<div class="col-sm-4 text-center" style="margin-bottom: 1em;">
				<a class="" title="Back" href="{{url('/employee')}}">
					<button type="button" class="btn btn-primary m-b-0">Return Back</button>
				</a>
			</div>

            <div class="col-sm-4 text-center" style="margin-bottom: 1em;">
                <button id="save" type="submit" class="btn btn-primary m-b-0">
                    <span class="ti-input"></span>
                    Save
                </button>
            </div>

			<div class="col-sm-4 text-center">
				<button type="submit" class="btn btn-primary m-b-0">Add Employee</button>
			</div>
		</div>

	{{ Form::close()}}

</div>

@endSection


@section('javascript')
    <script>
        $(function(){

            $('#total_salary').on('input', function() {
                calculate();
            });
            $('#basic_percentage').on('input', function() {
                calculate();
            });
            $('#medical_percentage').on('input', function() {
                calculate();
            });
            $('#provident_fund_percentage').on('input', function() {
                calculate();
            });

            function calculate(){
                var gross = parseInt($('#total_salary').val());
                var basics = parseInt($('#basic_percentage').val());
                var medicals = parseInt($('#medical_percentage').val());
                var funds = parseInt($('#provident_fund_percentage').val());
                var total="";
                if(!isNaN(basics)){
                    total = ((gross * basics)/100) ;
                    $('#basic').val(total);
                }
                if(!isNaN(medicals)){
                    var basic_amounts = parseInt($('#basic').val());
                    total = ((basic_amounts * medicals)/100) ;
                    $('#medical').val(total);
                }
                if(!isNaN(funds)){
                    total = ((gross * funds)/100) ;
                    $('#provident_fund').val(total);
                }

                calculate_tax();
            }

            function calculate_tax(){
                var basics = parseInt($('#basic').val());
                var tax_val = '';
                // var total = parseInt($('#total_salary').val()) * 12;
                var total = basics * 12;

                $('#yearly_income').val(total);

                var remaining = total - 300000;

                if(remaining>0){
                    if(remaining>100000){
                        remaining -= 100000;
                        tax_val = 5000;
                    }
                    else{
                        var tax = (5 * remaining)/100;
                        tax_val += tax;
                        remaining = 0;
                    }
                }

                if(remaining>0){
                    if(remaining>300000){
                        remaining -= 300000;
                        tax_val += 30000;
                    }
                    else{
                        tax = (10 * remaining)/100;
                        tax_val += tax;
                        remaining = 0;
                    }
                }

                if(remaining>0){
                    if(remaining>400000){
                        remaining -= 400000;
                        tax_val += 60000;
                    }
                    else{
                        tax = (15 * remaining)/100;
                        tax_val += tax;
                        remaining = 0;
                    }
                }

                if(remaining>0){
                    if(remaining>500000){
                        remaining -= 500000;
                        tax_val += 100000;
                    }
                    else{
                        tax = (20 * remaining)/100;
                        tax_val += tax;
                        remaining = 0;
                    }
                }

                if(remaining>0){
                    tax = (25 * remaining)/100;
                    tax_val += tax;
                }

                $('#yearly_tax').val(tax_val);

                // var monthly_tax = (tax_val/12).toFixed(2);
                var monthly_tax = Math.round((tax_val/12));
                $('#tax_amount').val(monthly_tax);

                var tds = Math.ceil((80 * monthly_tax)/100);
                $('#tax_payable').val(tds);
            }

        });
    </script>
@endsection
