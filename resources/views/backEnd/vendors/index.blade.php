@extends('backEnd.master')
@section('mainContent')

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
		<h5>Vendor Lists</h5>
        @can('Add Vendor')
		<a href="{{ route('vendors.create') }}" style="float: right; padding: 8px; color: white;" class="btn btn-success"> Add Vendor </a>
        @endcan
	</div>
    @can('View Vendor')
	<div class="card-block">
		<div class="table-responsive">
			<table id="basic-btn" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Serial</th>
						<th>ID</th>
						<th>Name</th>
						<th>Email</th>
						<th>Phone Number</th>
						<th>Contact Person Name</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@php $i = 1 @endphp
					@foreach($vendors as $vendor)
					<tr>
						<td>{{$i++}}</td>
			            <td>{{$vendor->unique_id}}</td>
			            <td>{{$vendor->vendor_name}}</td>
			            <td>{{$vendor->email}}</td>
			            <td>{{$vendor->phone_number}}</td>
			            <td>{{$vendor->contact_person_name}}</td>
			            <td>
			                <a href="{{ route('vendors.show',$vendor->id) }}" title="View"><button type="button" class="btn btn-success action-icon"><i class="fa fa-eye"></i></button></a>
	                        @can('Edit Vendor')
							<a href="{{ route('vendors.edit',$vendor->id) }}" title="Edit"><button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button></a>
	                            @endcan
	                            @if(Auth::user()->getRoleNames()->first() == 'Super Admin')
							<a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteVendorView', $vendor->id)}}">
								<button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>
							</a>
							@endif
			            </td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
    @endcan
</div>
@endSection
