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
		<h5>Client Lists</h5>
        @can('Add/Edit Client')
		<a href="{{ route('client.create') }}" style="float: right; padding: 8px; color: white;" class="btn btn-success"> Add Client </a>
        @endcan
	</div>
    @can('View Client List')
	<div class="card-block">
		<div class="table-responsive">
			<table id="basic-btn" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Serial</th>
						<th>Photo</th>
						<th>Client Name</th>
						<th>Abbreviation</th>
						<th>Ministry</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@php $i = 1 @endphp
					@foreach($clients as $client)
					<tr>
						<td>{{$i++}}</td>
                        <td>
                            <div class="d-inline-block align-middle">
                                @if(empty($client->client_image))
                                    <img src="{{asset('public/images/no_image.png')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                @else
                                    <img src="{{asset($client->client_image)}}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                @endif
                            </div>
                        </td>
			            <td>{{$client->client_name}}</td>
			            <td>{{$client->abbreviation}}</td>
			            <td>{{$client->ministry}}</td>
			            <td>
	                        @canany(['View Client Details','View Client Payment','	View Client Provided Documents'])
			                <a href="{{ route('client.show',$client->id) }}" title="View"><button type="button" class="btn btn-success action-icon"><i class="fa fa-eye"></i></button></a>
	                        @endcanany
	                        @can('Add/Edit Client')
							<a href="{{ route('client.edit',$client->id) }}" title="Edit"><button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button></a>
	                            @endcan
	                            @if(Auth::user()->getRoleNames()->first() == 'Super Admin')
							<a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteClientView', $client->id)}}">
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
