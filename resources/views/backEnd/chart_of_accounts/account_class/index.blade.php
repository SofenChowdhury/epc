@extends('backEnd.master')
@section('mainContent')
<div class="row">
	<div class="col-md-4">
		@if(session()->has('message-success'))
			<div class="alert alert-success mb-3 background-success" role="alert">
				{{ session()->get('message-success') }}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		@elseif(session()->has('message-danger'))
			<div class="alert alert-danger">
				{{ session()->get('message-danger') }}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		@endif
		@if(session()->has('message-success-delete'))
			<div class="alert alert-danger mb-3 background-danger" role="alert">
				{{ session()->get('message-success-delete') }}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		@elseif(session()->has('message-danger-delete'))
			<div class="alert alert-danger">
				{{ session()->get('message-danger-delete') }}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		@endif
		<div class="card">
			<div class="card-header">
				<h5>Add New Account Class</h5>
			</div>
			<div class="card-block">
				@if(isset($editData))
				{{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'account-class/'.$editData->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
				@else
				{{ Form::open(['class' => '', 'files' => true, 'url' => 'account-class',
				'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
				@endif
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="col-form-label">Account Class Name</label>
							<input type="text" class="form-control {{ $errors->has('class_name') ? ' is-invalid' : '' }}" name="class_name" id="name" placeholder="Account Class Name" value="{{isset($editData)? $editData->class_name : '' }}">

							@if ($errors->has('class_name'))
							<span class="invalid-feedback" role="alert">
								<span class="messages"><strong>{{ $errors->first('class_name') }}</strong></span>
							</span>
							@endif
						</div>
						<div class="form-group">
							<label class="col-form-label">Class Unit</label>
							<input type="text" class="form-control {{ $errors->has('class_unit') ? ' is-invalid' : '' }}" name="class_unit" id="name" placeholder="Account Class Unit" value="{{isset($editData)? $editData->class_unit : '' }}">

							@if ($errors->has('class_unit'))
							<span class="invalid-feedback" role="alert">
								<span class="messages"><strong>{{ $errors->first('class_unit') }}</strong></span>
							</span>
							@endif
						</div>

						<div class="form-group">
							<label class="col-form-label">Class Unit Type</label>
							<input type="text" class="form-control {{ $errors->has('class_unit_type') ? ' is-invalid' : '' }}" name="class_unit_type" id="name" placeholder="Account Class Unit Type" value="{{isset($editData)? $editData->class_unit_type : '' }}">

							@if ($errors->has('class_unit_type'))
							<span class="invalid-feedback" role="alert">
								<span class="messages"><strong>{{ $errors->first('class_unit_type') }}</strong></span>
							</span>
							@endif
						</div>


						<div class="form-group">
							<label class="col-form-label">Unit  Description</label>
							<textarea class="form-control {{ $errors->has('unit_description') ? ' is-invalid' : '' }}" name="unit_description" id="unit_description" placeholder="Account Class Unit Description">{{isset($editData)? $editData->unit_description : '' }}</textarea>

							@if ($errors->has('unit_description'))
							<span class="invalid-feedback" role="alert">
								<span class="messages"><strong>{{ $errors->first('unit_description') }}</strong></span>
							</span>
							@endif
						</div>

						<div class="form-group">
							<label class="col-form-label">Start ID</label>
							<input type="number" class="form-control {{ $errors->has('start_id') ? ' is-invalid' : '' }}" name="start_id" id="name" placeholder="Start ID" value="{{isset($editData)? $editData->start_id : '' }}">

							@if ($errors->has('start_id'))
							<span class="invalid-feedback" role="alert">
								<span class="messages"><strong>{{ $errors->first('start_id') }}</strong></span>
							</span>
							@endif
						</div>

						<div class="form-group">
							<label class="col-form-label">End ID</label>
							<input type="number" class="form-control {{ $errors->has('end_id') ? ' is-invalid' : '' }}" name="end_id" id="name" placeholder="End ID" value="{{isset($editData)? $editData->end_id : '' }}">

							@if ($errors->has('end_id'))
							<span class="invalid-feedback" role="alert">
								<span class="messages"><strong>{{ $errors->first('end_id') }}</strong></span>
							</span>
							@endif
						</div>
					</div>
				</div>
				<div class="form-group row mt-4">
					<div class="col-sm-12 text-center">
						<button type="submit" class="btn btn-primary m-b-0">Submit</button>
					</div>
				</div>
				{{ Form::close()}}
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">
				<h5>Account Category Lists</h5>
			</div>
			<div class="card-block">
				<div class="dt-responsive table-responsive">
					<table id="basic-btn" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Class ID</th>
								<th>Class Name</th>
								<th>Class Unit</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($account_class))
							@php $i = 1 @endphp
							@foreach($account_class as $value)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$value->class_name}}</td>
								<td>{{$value->class_unit}}</td>
								<td>
									<!-- <a href="" title="view"><button type="button" class="btn btn-success action-icon"><i class="fa fa-eye"></i></button></a> -->
									<a href="{{url('account-class/'.$value->id.'/edit')}}" title="edit"><button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button></a>
									<a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteAccountClassView', $value->id)}}">
										<button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>
									</a>
								</td>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

@endSection
