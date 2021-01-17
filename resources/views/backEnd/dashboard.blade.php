@extends('backEnd.master')
@section('mainContent')
<div class="row">

	<div class="col-xl-3 col-md-6">
		<div class="card">
			<div class="card-block">
				<div class="row align-items-center m-l-0">
					<div class="col-auto">
						<i class="fa fa-user f-30 text-c-red"></i>
					</div>
					<div class="col-auto">
						<h6 class="text-muted m-b-10">Total Employees</h6>
						<h2 class="m-b-0">{{ $total_employees }}</h2>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-xl-3 col-md-6">
		<div class="card">
			<div class="card-block">
				<div class="row align-items-center m-l-0">
					<div class="col-auto">
						<i class="fa fa-lightbulb-o f-30 text-c-blue"></i>
					</div>
					<div class="col-auto">
						<h6 class="text-muted m-b-10">Total Projects</h6>
						<h2 class="m-b-0">{{ $total_projects }}</h2>
					</div>
				</div>
			</div>
		</div>
	</div>

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center m-l-0">
                    <div class="col-auto">
                        <i class="fa fa-book f-30 text-c-green"></i>
                    </div>
                    <div class="col-auto">
                        <h6 class="text-muted m-b-10">Today's Transactions </h6>
                        <h2 class="m-b-0">{{ $total_transactions }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center m-l-0">
                    <div class="col-auto">
                        <i class="fa fa-calendar f-30 text-c-purple"></i>
                    </div>
                    <div class="col-auto">
                        <h6 class="text-muted m-b-10">Today's Transactions Total</h6>
                        <h2 class="m-b-0">{{ $transaction_sum }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">
	<div class="col-xl-6 col-md-6" >
		<div class="card">
			<div class="card-header">
				<h5>Attendance List</h5>
				<div class="card-header-right">
					<ul class="list-unstyled card-option">
						<li><i class="fa fa fa-wrench open-card-option"></i></li>
						<li><i class="fa fa-window-maximize full-card"></i></li>
						<li><i class="fa fa-minus minimize-card"></i></li>
						<li><i class="fa fa-refresh reload-card"></i></li>
						<li><i class="fa fa-trash close-card"></i></li>
					</ul>
				</div>
			</div>
			<div class="card-block row p-10" style="margin: 5px">
                @if(isset($attendances))
                    @php $i = 0 @endphp
                    @foreach($attendances as $attendance)
                        <div class="card col-md-2 col-sm-3">
                            <div class="align-middle pt-2 pb-2" style="text-align: center">
                                <a href="{{ route('employee.show',$attendance->employee_id) }}">
                                @if(isset($attendance->employee->employee_photo))
                                    <img src="{{ asset($attendance->employee->employee_photo) }}" alt="user image" class="img-radius img-80 align-center ">
                                @else
                                    <img src="{{asset('public/assets/images/user1.png')}}" alt="user image" class="img-radius img-80 align-top m-r-15">
                                @endif
    {{--                                <div class="d-inline-block">--}}
                                    <h6 class="m-t-10">{{$attendance->employee->first_name}} {{$attendance->employee->last_name}}</h6>
                                    @if(isset($attendance->employee->designation_id))
                                        @foreach($designations as $designation)
                                            @if($designation->id == $attendance->employee->designation_id)
                                                <p class="text-muted m-t-1 m-b-1">{{$designation->designation_name}}</p>
                                            @endif
                                        @endforeach
                                    @endif
    {{--                                </div>--}}
                                </a>
                                <p class="m-b-0">
                                    Time: {{date('h:i A', strtotime($attendance->in_time))}} - {{date('h:i A', strtotime($attendance->out_time))}}
                                </p>
                            </div>
                        </div>
                    @endforeach
                @endif
			</div>
		</div>
	</div>
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center m-l-0">
                    <div class="col-auto">
                        <i class="fa fa-users f-30 text-c-black"></i>
                    </div>
                    <div class="col-auto">
                        <h6 class="text-muted m-b-10"> Employees Present Today </h6>
                        <h2 class="m-b-0">{{ $present_employees }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center m-l-0">
                    <div class="col-auto">
                        <i class="fa fa-users f-30 text-c-black"></i>
                    </div>
                    <div class="col-auto">
                        <h6 class="text-muted m-b-10"> History Log </h6>
                    </div>
                    @can('View User List')
                        <div class="text-center">
                            <a href="history" class="b-b-primary text-primary">View all History</a>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>



{{--    hide part start--}}


{{--	<div class="col-xl-4 col-md-12">--}}
{{--		<div class="card">--}}
{{--			<div class="card-block">--}}
{{--				<div class="row">--}}
{{--					<div class="col">--}}
{{--						<h4>৳ 256.23</h4>--}}
{{--						<p class="text-muted">This Month</p>--}}
{{--					</div>--}}
{{--					<div class="col-auto">--}}
{{--						<label class="label label-success">+20%</label>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--				<div class="row">--}}
{{--					<div class="col-sm-8">--}}
{{--						<canvas id="this-month" style="height: 100px;"></canvas>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--		</div>--}}
{{--		<div class="card quater-card">--}}
{{--			<div class="card-block">--}}
{{--				<h6 class="text-muted m-b-15">Revenue</h6>--}}
{{--				<h4>৳ 3,9452.50</h4>--}}
{{--				<br>--}}
{{--				<p class="text-muted">Online Revenue<span class="f-right">80%</span></p>--}}
{{--				<div class="progress">--}}
{{--					<div class="progress-bar bg-c-blue" style="width: 80%"></div>--}}
{{--				</div>--}}
{{--				<br>--}}
{{--				<p class="text-muted">Offline Revenue<span class="f-right">50%</span></p>--}}
{{--				<div class="progress">--}}
{{--					<div class="progress-bar bg-c-green" style="width: 50%"></div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--		</div>--}}
{{--	</div>--}}


{{--hide field end--}}





	<div class="col-xl-8 col-md-12">
		<div class="card table-card">
			<div class="card-header">
				<h5>Projects</h5>
				<div class="card-header-right">
					<ul class="list-unstyled card-option">
						<li><i class="fa fa fa-wrench open-card-option"></i></li>
						<li><i class="fa fa-window-maximize full-card"></i></li>
						<li><i class="fa fa-minus minimize-card"></i></li>
						<li><i class="fa fa-refresh reload-card"></i></li>
						<li><i class="fa fa-trash close-card"></i></li>
					</ul>
				</div>
			</div>
			<div class="card-block">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
                                <th>Project Name</th>
                                <th>Project ID</th>
                                <th>Contract Type</th>
								<th class="text-right">Status</th>
							</tr>
						</thead>
						<tbody>
                        @if(isset($projects))
                            @php $i = 0 @endphp
                            @foreach($projects as $project)
                                @if($i<4)
                                <tr>
                                    <td>
                                        <div class="d-inline-block align-middle">
                                            <img src="{{asset('public/assets/images/project3.png')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                            <div class="d-inline-block">
                                                <h6>{{ $project->project_name }}</h6>
                                                <p class="text-muted m-b-0">{{ $project->project_type }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $project->project_code }}-00{{ $project->project_phase }}</td>
                                    <td>
                                        @if( $project->contract_type == 1)
                                            JV
                                        @elseif( $project->contract_type == 2)
                                            Local
                                        @else
                                            Lead
                                        @endif
                                    </td>
                                    <td class="text-right"><label class="label label-danger">{{ ucwords($project->project_status) }}</label></td>
                                </tr>
                                @php $i++ @endphp
                                @endif
                            @endforeach
                        @endif
{{--							<tr>--}}
{{--								<td>--}}
{{--									<div class="chk-option">--}}
{{--										<div class="checkbox-fade fade-in-primary">--}}
{{--											<label class="check-task">--}}
{{--												<input type="checkbox" value="">--}}
{{--												<span class="cr">--}}
{{--													<i class="cr-icon fa fa-check txt-default"></i>--}}
{{--												</span>--}}
{{--											</label>--}}
{{--										</div>--}}
{{--									</div>--}}
{{--									<div class="d-inline-block align-middle">--}}
{{--										<img src="{{asset('public/assets/images/avatar-2.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15">--}}
{{--										<div class="d-inline-block">--}}
{{--											<h6>Hasan Masud</h6>--}}
{{--											<p class="text-muted m-b-0">Developer</p>--}}
{{--										</div>--}}
{{--									</div>--}}
{{--								</td>--}}
{{--								<td>Guruable</td>--}}
{{--								<td>Sep, 22</td>--}}
{{--								<td class="text-right"><label class="label label-primary">high</label></td>--}}
{{--							</tr>--}}
						</tbody>
					</table>
                    @can('view Project List')
						<div class="text-right m-r-20">
							<a href="project" class=" b-b-primary text-primary">View all Projects</a>
						</div>
					@endcan
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-4 col-md-12">
		<div class="card ">
			<div class="card-header">
				<h5>Users</h5>
                @if(isset($users))
                    @php $i = 0 @endphp
                    @foreach($users as $user)
                        @php $i++; $total = $i; @endphp
                    @endforeach
                    <h6 class="m-b-0">Total: {{$total}}</h6>
                @endif
				<div class="card-header-right">
					<ul class="list-unstyled card-option">
						<li><i class="fa fa fa-wrench open-card-option"></i></li>
						<li><i class="fa fa-window-maximize full-card"></i></li>
						<li><i class="fa fa-minus minimize-card"></i></li>
						<li><i class="fa fa-refresh reload-card"></i></li>
						<li><i class="fa fa-trash close-card"></i></li>
					</ul>
				</div>
			</div>
			<div class="card-block">
				@if(isset($users))
					@php $i = 0 @endphp
					@foreach($users as $user)
						@if($i<5)
							<div class="align-middle m-b-40">
								@if(isset($user->employee_photo))
									<img src="{{ asset($user->employee_photo) }}" alt="user image" class="img-radius img-40 align-top m-r-15">
								@else
									<img src="{{asset('public/assets/images/user1.png')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
								@endif
								<!-- <img src="{{asset('public/assets/images/avatar-5.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15"> -->
								<div class="d-inline-block">
									<h6>{{$user->name}}</h6>
									@if(isset($user->designation_id))
										@foreach($designations as $designation)
											@if($designation->id == $user->designation_id)
											<p class="text-muted m-b-0">{{$designation->designation_name}}</p>
											@endif
										@endforeach
									@endif
								</div>
							</div>
							@php $i++ @endphp
						@endif
					@endforeach
				@endif
                @can('View User List')
					<div class="text-center">
						<a href="user" class="b-b-primary text-primary">View all Users</a>
					</div>
				@endcan
			</div>

		</div>
	</div>

</div>

@endsection

@section('javascript')
<script type="text/javascript">
	console.log($users);
</script>
@endsection
