@extends('backEnd.master')
@section('mainContent')
<div class="card">
	<div class="card-header">
		<h5>Add Task for Project : {{ $project->project_name}} </h5>
	</div>
	<div class="card-block">
		{{ Form::open(['class' => '', 'files' => true, 'url' => 'task', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
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
                    @if(isset($maxAmendment))
                        @for($y=1; $y<=$maxAmendment; $y++)
                            <option
                                value="{{ $y}}">{{$y}}</option>
                        @endfor
                    @endif
                </select>
            </div>
        </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="task_id"><span class="important">*</span> Task ID :</label>
                    <input type="text" class="form-control  {{ $errors->has('task_id') ? ' is-invalid' : '' }}" value="{{ old('task_id') }}" name="task_id" />
                    @if ( $errors->has('task_id') )
                        <span class="invalid-feedback" role="alert" >
                                <span class="messages"><strong>{{ $errors->first('task_id') }}</strong></span>
                            </span>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="parent_id">Sub-Task of : </label>
                    <select class="js-example-basic-single col-sm-12 {{ $errors->has('parent_id') ? ' is-invalid' : '' }}" name="parent_id" id="parent_id">
                        <option value="">Select Task ID </option>
                        @if($parents)
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id')== $parent->task_id ? 'selected' : old('parent_id') }} >{{ $parent->task_id }}</option>
                            @endforeach
                        @endif
                    </select>
                    @if ( $errors->has('parent_id') )
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('parent_id') }}</strong></span>
						</span>
                    @endif
                </div>
            </div>

			<div class="row">
				<div class="form-group col-md-6">
				  	<label for="task_name"><span class="important">*</span> Task Name :</label>
				  	<input type="text" class="form-control  {{ $errors->has('task_name') ? ' is-invalid' : '' }}" value="{{ old('task_name') }}" name="task_name" />
                    <p style="color: darkred">Maximum 150 characters</p>
                    @if ( $errors->has('task_name') )
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('task_name') }}</strong></span>
						</span>
					@endif
				</div>

				<div class="form-group col-md-3">
					<label for="priority">Priority :</label>
				  	<select class="js-example-basic-single col-sm-12 {{ $errors->has('priority') ? ' is-invalid' : '' }}" name="priority" id="priority">
						<option value="">Select Priority</option>
						<option value="2">Urgent</option>
						<option value="1">High</option>
						<option value="0">Medium</option>
					</select>
					@if ($errors->has('priority'))
					<span class="invalid-feedback invalid-select" role="alert">
						<strong class="messages">{{ $errors->first('priority') }}</strong>
					</span>
					@endif
				</div>

				<div class="form-group col-md-3">
				  	<label for="task_status">Status :</label>
				  	<select class="js-example-basic-single col-sm-12 {{ $errors->has('task_status') ? ' is-invalid' : '' }}" name="task_status" id="task_status">
						<option value="new">New</option>
						<option value="ongoing">Ongoing</option>
						<option value="waiting">Waiting</option>
						<!-- <option value="completed">Completed</option> -->
						<!-- <option value="cancelled">Cancelled</option> -->
					</select>
					@if ($errors->has('task_status'))
					<span class="invalid-feedback invalid-select" role="alert">
						<strong class="messages">{{ $errors->first('task_status') }}</strong>
					</span>
					@endif
				</div>

			</div>

			<div class="row">
				<div class="form-group col-md-6">
				  	<label for="employee_id">Assigned To : </label>
				  	<select class="js-example-basic-single col-sm-12 {{ $errors->has('employee_id') ? ' is-invalid' : '' }}" name="employee_id" id="employee_id">
						<option value="">Select Employee </option>
							@foreach($project->project_employees as $employee)
                                @if(isset($employee->employee_id))
								<option value="{{ $employee->employee_id }}" {{ old('employee_id')== $employee->employee_id ? 'selected' : old('employee_id') }} >{{ $employee->employee->first_name }} {{ $employee->employee->last_name }}</option>
							    @endif
                            @endforeach
					</select>
				  	@if ( $errors->has('employee_id') )
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('employee_id') }}</strong></span>
						</span>
					@endif
				</div>

				<div class="form-group col-md-6">
				  <label for="due_date">Due Date :</label>
				  <input type="" class="form-control datepicker {{ $errors->has('due_date') ? ' is-invalid' : '' }}" value="{{ old('due_date') }}" name="due_date"/>
				  	@if ($errors->has('due_date'))
					    <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('due_date') }}</strong></span>
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
