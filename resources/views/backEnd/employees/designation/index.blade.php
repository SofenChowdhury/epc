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
            @can('Add/Edit Designation')
		<div class="card">
			<div class="card-header">
				<h5>Add New Designation</h5>
			</div>
			<div class="card-block">
				@if(isset($editData))
				{{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'designation/'.$editData->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
				@else
				{{ Form::open(['class' => '', 'files' => true, 'url' => 'designation',
				'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
				@endif
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="designation_name"><span class="important">*</span> Designation Name</label>
							<input type="text" class="form-control {{ $errors->has('designation_name') ? ' is-invalid' : '' }}" name="designation_name" id="designation_name" value="{{isset($editData)? $editData->designation_name : old('designation_name') }}">
                            @if ($errors->has('designation_name'))
							<span class="invalid-feedback" role="alert"><span class="messages"><strong>{{ $errors->first('designation_name') }}</strong></span></span>
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
                @endcan
	</div>
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">
				<h5>Designation Lists</h5>
			</div>
			<div class="card-block">
				<div class="dt-responsive table-responsive">
					<table id="basic-btn" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Serial</th>
								<th>Designation Name</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($designations))
							@php $i = 1 @endphp
							@foreach($designations as $designation)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$designation->designation_name}}</td>
								<td><button type="button" class="btn btn-success btn-sm">Active</button></td>
								<td>
                                    @can('Add/Edit Designation')
									<a href="{{url('designation/'.$designation->id.'/edit')}}" title="edit"><button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button></a>
                                    @endcan
                                    @if(Auth::user()->getRoleNames()->first() == 'Super Admin')
									<a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteDesignationView', $designation->id)}}">
										<button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>
									</a>
									@endif
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
