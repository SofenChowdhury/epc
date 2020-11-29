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
				<h5>Add New Account Category</h5>
			</div>
			<div class="card-block">
				@if(isset($editData))
				{{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'account-category/'.$editData->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
				@else
				{{ Form::open(['class' => '', 'files' => true, 'url' => 'account-category',
				'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
				@endif
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="col-form-label">Account Category Name</label>
							<input type="text" class="form-control {{ $errors->has('category_name') ? ' is-invalid' : '' }}" name="category_name" id="name" placeholder="Account Category Name" value="{{isset($editData)? $editData->category_name : '' }}">

							@if ($errors->has('category_name'))
							<span class="invalid-feedback" role="alert">
								<span class="messages"><strong>{{ $errors->first('category_name') }}</strong></span>
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
								<th>Category ID</th>
								<th>Category Name</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($accounts_category))
							@php $i = 1 @endphp
							@foreach($accounts_category as $value)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$value->category_name}}</td>
								<td><button type="button" class="btn btn-success btn-sm">Active</button></td>
								<td>
									<!-- <a href="" title="view"><button type="button" class="btn btn-success action-icon"><i class="fa fa-eye"></i></button></a> -->
									<a href="{{url('account-category/'.$value->id.'/edit')}}" title="edit"><button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button></a>
									<a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteAccountCategoryView', $value->id)}}">
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
