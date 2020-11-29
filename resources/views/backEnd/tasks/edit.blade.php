@extends('backEnd.master')
@section('mainContent')
<div class="card">
	<div class="card-header">
		<h5>Edit Task</h5>
	</div>
	<div class="card-block">
	{{ Form::open(['class' => '', 'files' => true, 'url' => 'task/'.$editData->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
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
                <label for="task_id">Task ID :</label>
                <input type="text" class="form-control  {{ $errors->has('task_id') ? ' is-invalid' : '' }}" value="{{ $editData->task_id }}" name="task_id" />
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
                            <option value="{{ $parent->id }}" {{ $editData->parent_id == $parent->id ? 'selected' : '' }} >{{ $parent->task_id }}</option>
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
			  	<label for="task_name">Task Name :</label>
			  	<input type="text" class="form-control  {{ $errors->has('task_name') ? ' is-invalid' : '' }}" value="{{ $editData->task_name }}" name="task_name" />
			  	@if ( $errors->has('task_name') )
				    <span class="invalid-feedback" role="alert" >
						<span class="messages"><strong>{{ $errors->first('task_name') }}</strong></span>
					</span>
				@endif
			</div>

			<div class="form-group col-md-3">
				<label for="priority">Priority :</label>
			  	<select class="js-example-basic-single col-sm-12 {{ $errors->has('priority') ? ' is-invalid' : '' }}" name="priority" id="priority" >
					<option value="2"
						@if($editData->priority == 2)
							selected
						@endif> Urgent
					</option>
					<option value="1"
						@if($editData->priority == 1)
							selected
						@endif> High
					</option>
					<option value="0"
						@if($editData->priority == 0)
							selected
						@endif> Medium
					</option>
				</select>
				@if ($errors->has('priority'))
				<span class="invalid-feedback invalid-select" role="alert">
					<strong class="messages">{{ $errors->first('priority') }}</strong>
				</span>
				@endif
			</div>

			<div class="form-group col-md-3">
			  	<label for="task_status"><span class="important">*</span> Status :</label>
			  	<select class="js-example-basic-single col-sm-12 {{ $errors->has('task_status') ? ' is-invalid' : '' }}" name="task_status" id="task_status" required>
					<option value="new"
						@if($editData->task_status == 'new')
							selected
						@endif> New
					</option>
					<option value="ongoing"
						@if($editData->task_status == 'ongoing')
							selected
						@endif> Ongoing
					</option>
					<option value="waiting"
						@if($editData->task_status == 'waiting')
							selected
						@endif> Waiting
					</option>
					<option value="completed"
						@if($editData->task_status == 'completed')
							selected
						@endif> Completed
					</option>
					<option value="cancelled"
						@if($editData->task_status == 'cancelled')
							selected
						@endif> Cancelled
					</option>
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
                    @if(isset($employees))
                        @foreach($employees as $employee)
{{--                            <option value="{{ $employee->employee_id }}" {{ $editData->employee_id == $employee->employee_id ? 'selected' : '' }} >{{ $employee->employee_id }}</option>--}}
                            <option value="{{ $employee->employee_id }}" {{ $editData->employee_id == $employee->employee_id ? 'selected' : '' }} >{{ $employee->employee->unique_id }} {{ $employee->employee->first_name }} {{ $employee->employee->last_name }}</option>
                     @endforeach
                    @endif
                </select>
			  	@if ( $errors->has('employee_id') )
				    <span class="invalid-feedback" role="alert" >
						<span class="messages"><strong>{{ $errors->first('employee_id') }}</strong></span>
					</span>
				@endif
			</div>

			<div class="form-group col-md-6">
			  <label for="due_date">Due Date :</label>
			  <input type="" class="form-control datepicker {{ $errors->has('due_date') ? ' is-invalid' : '' }}" value="{{ date('d-m-Y', strtotime($editData->due_date)) }}" name="due_date"/>
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
			  	<textarea class="form-control" value="" name="description">{{  $editData->description }}</textarea>
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
				<button type="submit" class="btn btn-primary m-b-0">Update</button>
			</div>
		</div>
	{{ Form::close()}}

	</div>
</div>

@endSection
