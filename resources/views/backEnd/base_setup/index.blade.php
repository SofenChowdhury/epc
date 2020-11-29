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
				<h5>Add New Base Setup</h5>
			</div>
			<div class="card-block">
				@if(isset($editData))
				{{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'base_setup/'.$editData->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="col-form-label">Base Group</label>
								<select class="js-example-basic-single col-sm-12 {{ $errors->has('base_group_id') ? ' is-invalid' : '' }}" name="base_group_id" id="base_group_id">
									<option value="">Select Base Group</option>
									@if(isset($base_groups))
										@foreach($base_groups as $key=>$value)
										<option value="{{$value->id}}"
											@if(isset($editData))
												@if($editData->base_group_id == $value->id)
													selected
												@endif
											@endif
											>{{$value->name}}
										</option>
										@endforeach
									@endif
								</select>
								@if ($errors->has('base_group_id'))
								<span class="invalid-feedback invalid-select" role="alert">
									<strong>{{ $errors->first('base_group_id') }}</strong>
								</span>
								@endif
							</div>
							<div class="form-group">
								<label class="col-form-label">{{ __('Base Setup Name') }}</label>
								<input type="text" class="form-control {{ $errors->has('base_setup_name') ? ' is-invalid' : '' }}" name="base_setup_name" id="base_setup_name" placeholder="Base Group Name" value="{{isset($editData)? $editData->base_setup_name : old('base_setup_name') }}">

								@if ($errors->has('base_setup_name'))
								<span class="invalid-feedback" role="alert">
									<span class="messages"><strong>{{ $errors->first('base_setup_name') }}</strong></span>
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
				{{ Form::open(['class' => '', 'files' => true, 'url' => 'base_setup',
				'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
				                <label for="base_group_id" class="col-form-label">{{ __('Base Group') }}</label>
				                <div class="">
					                <select class="js-example-basic-single col-sm-12 {{ $errors->has('base_group_id') ? ' is-invalid' : '' }}" name="base_group_id" id="base_group_id">
									<option value="">Select Group Name</option>
									@if(isset($base_groups))
										@foreach($base_groups as $base_group)
											<option value="{{ $base_group->id }}" {{ old('base_group_id')== $base_group->id ? 'selected' : ''  }} >{{$base_group->name}}</option>
										@endforeach
									@endif
									</select>
									@if ($errors->has('base_group_id'))
									<span class="invalid-feedback invalid-select" role="alert">
										<strong>{{ $errors->first('base_group_id') }}</strong>
									</span>
									@endif
								</div>
				            </div>
							<div class="form-group">
								<label class="col-form-label">{{ __('Base Setup Name') }}</label>
								<input type="text" class="form-control {{ $errors->has('base_setup_name') ? ' is-invalid' : '' }}" name="base_setup_name" id="base_setup_name" placeholder="Base Group Name" value="{{isset($editData)? $editData->base_setup_name : old('base_setup_name') }}">

								@if ($errors->has('base_setup_name'))
								<span class="invalid-feedback" role="alert">
									<span class="messages"><strong>{{ $errors->first('base_setup_name') }}</strong></span>
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
				<h5 class="card-header-text">Base Setup lists</h5>
			</div>
			<div class="card-block accordion-block">
				<div id="accordion" role="tablist" aria-multiselectable="true">
					@if(isset($base_setups))
						@foreach($base_groups as $base_group)
							<div class="accordion-panel">
								<div class="accordion-heading" role="tab" id="headingOne">
									<h3 class="card-title accordion-title">
									<a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#{{$base_group->name}}" aria-expanded="false" aria-controls="collapseOne">
										{{$base_group->name}}
									</a>
									</h3>
								</div>
								<div id="{{$base_group->name}}" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingOne" style="">
									<div class="accordion-content accordion-desc">
										<div class="card-block">
											<div class="dt-responsive table-responsive">
												<table id="basic-btn" class="table table-striped table-bordered">
													<thead>
														<tr>
															<th>Serial</th>
															<th>Base setup Name</th>
															<th>Status</th>
															<th>Actions</th>
														</tr>
													</thead>
													<tbody>
														@if(isset($base_setups))
														@php $i = 1 @endphp
														@foreach($base_setups as $base_setup)
														<tr>
															@if($base_setup->base_group_id == $base_group->id)
																<td>{{$i++}}</td>
																<td>{{$base_setup->base_setup_name}}</td>
																<td><button type="button" class="btn btn-success btn-sm">Active</button></td>
																<td>
																	<!-- <a href="" title="view"><button type="button" class="btn btn-success action-icon"><i class="fa fa-eye"></i></button></a> -->
																	<a href="{{url('base_setup/'.$base_setup->id.'/edit')}}" title="edit"><button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button></a>
																	<a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteBaseSetupView', $base_setup->id)}}">
																		<button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>
																	</a>
																</td>
															@endif
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
						@endforeach
					@endif

					@if ($errors->has('base_setup_name'))
					<span class="invalid-feedback invalid-select" role="alert">
						<strong>{{ $errors->first('base_setup_name') }}</strong>
					</span>
					@endif

				</div>
			</div>
		</div>
	</div>
</div>

@endSection
