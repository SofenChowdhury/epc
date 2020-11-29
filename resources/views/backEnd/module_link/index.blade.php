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
				<h5>Add New Module Links</h5>
			</div>
			<div class="card-block">
				@if(isset($editData))
				{{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'module_link/'.$editData->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="col-form-label">Modules</label>
								<select class="js-example-basic-single col-sm-12 {{ $errors->has('module_id') ? ' is-invalid' : '' }}" name="module_id" id="module_id">
									<option value="">Select Module</option>
									@if(isset($modules))
										@foreach($modules as $key=>$value)
										<option value="{{$value->id}}"
											@if(isset($editData))
												@if($editData->module_id == $value->id)
													selected
												@endif
											@endif
											>{{$value->name}}
										</option>
										@endforeach
									@endif
								</select>
								@if ($errors->has('module_id'))
								<span class="invalid-feedback invalid-select" role="alert">
									<strong>{{ $errors->first('module_id') }}</strong>
								</span>
								@endif
							</div>
							<div class="form-group">
								<label class="col-form-label">{{ __('Module Links Name') }}</label>
								<input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" placeholder="Module Name" value="{{isset($editData)? $editData->name : old('name') }}">

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
							<button type="submit" class="btn btn-primary m-b-0">Update</button>
						</div>
					</div>
				@else
				{{ Form::open(['class' => '', 'files' => true, 'url' => 'module_link',
				'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
				                <label for="module_id" class="col-form-label"><span class="important">*</span> {{ __('Modules') }}</label>
				                <div class="">
					                <select class="js-example-basic-single col-sm-12 {{ $errors->has('module_id') ? ' is-invalid' : '' }}" name="module_id" id="module_id">
									<option value="">Select Modules</option>
									@if(isset($modules))
										@foreach($modules as $module)
											<option value="{{ $module->id }}" {{ old('module_id')== $module->id ? 'selected' : ''  }} >{{$module->name}}</option>
										@endforeach
									@endif
									</select>
									@if ($errors->has('module_id'))
									<span class="invalid-feedback invalid-select" role="alert">
										<strong>{{ $errors->first('module_id') }}</strong>
									</span>
									@endif
								</div>
				            </div>
							<div class="form-group">
								<label class="col-form-label"><span class="important">*</span> {{ __('Module Links Name') }}</label>
								<input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" placeholder="Module links name" value="{{isset($editData)? $editData->name : old('name') }}">

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
				@endif
				{{ Form::close()}}
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">
				<h5>Module Link Lists</h5>
			</div>
			<div class="card-block">
				<div class="dt-responsive table-responsive">
				<table id="basic-btn" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Serial</th>
							<th>Module Name</th>
							<th>Module Link Name</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@if(isset($module_links))
							@php $i = 1 @endphp
							@foreach($module_links as $module_link)
							<tr>
								<td>{{$i++}}</td>
								@foreach($modules as $module)
									@if($module->id == $module_link->module_id)
									<td>{{ $module->name }}</td>
									@endif
								@endforeach
								<td>{{$module_link->name}}</td>
								<td><button type="button" class="btn btn-success btn-sm">Active</button></td>
								<td>
									<a href="{{ url('module_link/'.$module_link->id.'/edit') }}" title="edit">
										<button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button>
									</a>
									<a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteModuleLinkView', $module_link->id)}}">
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
