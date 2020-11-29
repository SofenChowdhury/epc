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
				<h5>Add New Base Group</h5>
			</div>
			<div class="card-block">
				@if(isset($editData))
				{{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'base_group/'.$editData->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
				@else
				{{ Form::open(['class' => '', 'files' => true, 'url' => 'base_group',
				'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
				@endif
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="col-form-label">Base Group Name</label>
							<input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" placeholder="Base Group Name" value="{{isset($editData)? $editData->name : old('name') }}">

							@if ($errors->has('name'))
							<span class="invalid-feedback" role="alert">
								<span class="messages"><strong>{{ $errors->first('name') }}</strong></span>
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
				<h5>Group Lists</h5>
			</div>
			<div class="card-block">
				<div class="dt-responsive table-responsive">
					<table id="basic-btn" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Serial</th>
								<th>Group Name</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($base_groups))
							@php $i = 1 @endphp
							@foreach($base_groups as $base_group)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$base_group->name}}</td>
								<td><button type="button" class="btn btn-success btn-sm">Active</button></td>
								<td>
									<!-- <a href="" title="view"><button type="button" class="btn btn-success action-icon"><i class="fa fa-eye"></i></button></a> -->
									<a href="{{url('base_group/'.$base_group->id.'/edit')}}" title="edit"><button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button></a>
									<!-- <a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteBaseGroupView', $base_group->id)}}">
										<button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>
									</a> -->
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
