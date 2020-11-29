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

<div class="card ">
	<div class="card-header">
		<h5>Notifications</h5>
	</div>
	<div class="card-block">
		<div class="table-responsive">
			<table class="table table-bordered nowrap">

				@foreach(Auth::user()->unreadNotifications as $notification)
				<tr>
					<td class="" style="background-color: #e5e5e5;">
						@if(isset($notification->data['route']))
						<a href="{{ route( $notification->data['route'],$notification->data['id'] ) }}">
						@elseif(isset($notification->data['id']))
						<a href="{{ route('employee.show',$notification->data['id']) }}">
						@else
						<a href="{{ route('employee.show',Auth::user()->employee_id) }}">
						@endif
							<div style="color: grey;">
								<h5 style="font-size: 1.3em; color: #ff0000;">
									{{ $notification->data['title'] }}
								</h5><br>
								<p style="font-size: 1.5em;">{{ $notification->data['data'] }}</p>
								<span>{{ date('Y-F-d  h:i A', strtotime($notification->created_at)) }}</span>
								@php
									$notification->markAsRead();
								@endphp
							</div>
						</a>
					</td>
				</tr>
				@endforeach
				@foreach(Auth::user()->readNotifications as $notification)
				<tr>
					<td class="">
						@if(isset($notification->data['route']))
						<a href="{{ route( $notification->data['route'],$notification->data['id'] ) }}">
						@elseif(isset($notification->data['id']))
						<a href="{{ route('employee.show',$notification->data['id']) }}">
						@else
						<a href="{{ route('employee.show',Auth::user()->employee_id) }}">
						@endif
							<div style="color: grey;">
								<h5 style="font-size: 1.3em; color: red;">
									{{ $notification->data['title'] }}
								</h5><br>
								<p style="font-size: 1.5em;">{{ $notification->data['data'] }} </p>
								<span>{{ date('Y-F-d  h:i A', strtotime($notification->created_at)) }}</span>
							</div>
						</a>
					</td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>
@endSection
