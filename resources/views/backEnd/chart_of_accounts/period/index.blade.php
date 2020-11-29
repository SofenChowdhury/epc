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
				@if(isset($editData))
					<h5>Edit period</h5>
				@else
					<h5>Add New period</h5>
				@endif
			</div>
			<div class="card-block">
				@if(isset($editData))
				{{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'period/'.$editData->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
				@else
				{{ Form::open(['class' => '', 'files' => true, 'url' => 'period',
				'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
				@endif
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="col-form-label">Period Name</label>
							<input type="text" class="form-control {{ $errors->has('period_name') ? ' is-invalid' : '' }}" name="period_name" id="period_name" placeholder="Period Name" value="{{isset($editData)? $editData->period_name : old('period_name') }}">

							@if ($errors->has('period_name'))
							<span class="invalid-feedback" role="alert">
								<span class="messages"><strong>{{ $errors->first('period_name') }}</strong></span>
							</span>
							@endif
						</div>
						<div class="form-group ">
						  	<label class="col-form-label" for="period_starts">Period Start Date:</label>
						  	<input type="" class="form-control datepicker  {{ $errors->has('period_starts') ? ' is-invalid' : old('period_starts') }}" value="{{isset($editData)? date('d-m-Y', strtotime($editData->period_starts)) : old('period_starts') }}" name="period_starts"/>
						  	@if ($errors->has('period_starts'))
							    <span class="invalid-feedback" role="alert" >
									<span class="messages"><strong>{{ $errors->first('period_starts') }}</strong></span>
								</span>
							@endif
						</div>

						<div class="form-group ">
						  	<label class="col-form-label" for="period_ends">Period End Date:</label>
						  	<input type="" class="form-control datepicker  {{ $errors->has('period_ends') ? ' is-invalid' : old('period_ends') }}" value="{{isset($editData)? date('d-m-Y', strtotime($editData->period_ends)) : old('period_ends') }}" name="period_ends"/>
						  	@if ($errors->has('period_ends'))
							    <span class="invalid-feedback" role="alert" >
									<span class="messages"><strong>{{ $errors->first('period_ends') }}</strong></span>
								</span>
							@endif
						</div>

						<div class="form-group ">
						  	<label class="col-form-label" for="period_status">Period Status:</label>
						  	<select class="js-example-basic-single col-sm-12 {{ $errors->has('period_status') ? ' is-invalid' : '' }}" name="period_status" id="period_status">
								<option value="">Select Period status</option>
								@if (isset($editData))
									@if ($editData->active_status == 1)
										<option selected="selected" value="1">Active</option>
										<option value="0">Not Active</option>
									@else
										<option value="1"> Active</option>
										<option selected="selected" value="0">Not Active</option>
									@endif
								@else
									<option value="1">Active</option>
									<option value="0">Not Active</option>
								@endif
							</select>
							@if ($errors->has('period_status'))
								<span class="invalid-feedback invalid-select" role="alert">
									<strong>{{ $errors->first('period_status') }}</strong>
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
				<h5>Period Lists</h5>
			</div>
			<div class="card-block">
				<div class="dt-responsive table-responsive">
					<table id="basic-btn" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Period ID</th>
								<th>Period Name</th>
								<th>Period Start Date</th>
								<th>Period End Date</th>
								<th>Period Active status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($periods))
							@php $i = 1 @endphp
							@foreach($periods as $period)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$period->period_name}}</td>
								<td>{{ date('d-M-Y', strtotime($period->period_starts)) }}</td>
								<td>{{ date('d-M-Y', strtotime($period->period_ends)) }}</td>
							    @if ($period->active_status == 1)
									<td><span class="pcoded-badge label label-success">Active</span></td>
								@else
									<td><span class="pcoded-badge label label-danger">Not Active</span></td>
							    @endif
								<td>
									<!-- <a href="" title="view"><button type="button" class="btn btn-success action-icon"><i class="fa fa-eye"></i></button></a> -->
									<a href="{{url('period/'.$period->id.'/edit')}}" title="edit"><button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button></a>
									<a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deletePeriodView', $period->id)}}">
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
