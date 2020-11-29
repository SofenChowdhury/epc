<nav class="navbar header-navbar pcoded-header">
	<div class="navbar-wrapper">
		<div class="navbar-logo">
			<a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="#!">
				<i class="ti-menu"></i>
			</a>
			<div class="mobile-search waves-effect waves-light">
				<div class="header-search">
					<div class="main-search morphsearch-search">
						<div class="input-group">
							<span class="input-group-prepend search-close"><i class="ti-close input-group-text"></i></span>
							<input type="text" class="form-control" placeholder="Enter Keyword">
							<span class="input-group-append search-btn"><i class="ti-search input-group-text"></i></span>
						</div>
					</div>
				</div>
			</div>
			<a href="{{url('/')}}"></a>
			<a class="mobile-options waves-effect waves-light">
				<i class="ti-more"></i>
			</a>
		</div>
		<div class="navbar-container container-fluid">
			<ul class="nav-left">
				<li>
					<div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu" style="color: white"></i></a></div>
				</li>
				<li class="header-search">
					<div class="main-search morphsearch-search">
						<div class="input-group">
							<span class="input-group-prepend search-close"><i class="ti-close input-group-text"></i></span>
							<input type="text" class="form-control" placeholder="Enter Keyword">
							<span class="input-group-append search-btn"><i class="ti-search input-group-text"></i></span>
						</div>
					</div>
				</li>
				<li>
					<a href="#!" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
						<i class="ti-fullscreen" style="color: white"></i>
					</a>
				</li>
			</ul>
			<ul class="nav-right">
				<li class="header-notification">
					<a href="#!" class="">
						<i class="ti-bell" style="color: white"></i>
						<span class="badge bg-c-red waves-effect waves-light" style="color: white">{{ Auth::user()->unreadNotifications->count() }}</span>
					</a>
					<ul class="show-notification" style="max-height: 25em; overflow: auto;">
						<li>
							<h6>Notifications</h6>
							<label class="label label-success"><a href="{{ url('allnotifications') }}" style="color: white;"> All Notifications </a></label>
							<label class="label label-danger"><a href="#" style="color: white;">{{ Auth::user()->unreadNotifications->count() }} New </a></label>
						</li>
						@foreach(Auth::user()->unreadNotifications as $notification)
						<li class="waves-effect waves-light" style="background-color: #e5e5e5;">
							@if(isset($notification->data['route']))
							<a href="{{ route( $notification->data['route'],$notification->data['id'] ) }}">
                            @elseif(isset($notification->data['url']))
                            <a href="{{ url( $notification->data['url'] ) }}">
							@elseif(isset($notification->data['id']))
							<a href="{{ route('employee.show',$notification->data['id']) }}">
							@else
							<a href="{{ route('employee.show',Auth::user()->employee_id) }}">
							@endif
								<div class="media ">
									<div class="media-body">
										<h5 class="notification-user">
											{{ $notification->data['title'] }}</h5>
										<p class="notification-msg">{{ $notification->data['data'] }}</p>
										<span class="notification-time">{{ date('Y-F-d  h:i A', strtotime($notification->created_at)) }}</span>
									</div>
									@php
										$notification->markAsRead();
									@endphp
								</div>
							</a>
						</li>
						@endforeach
						@foreach(Auth::user()->readNotifications as $notification)
						<li class="waves-effect waves-light">
							@if(isset($notification->data['route']))
							<a href="{{ route( $notification->data['route'],$notification->data['id'] ) }}">
                            @elseif(isset($notification->data['url']))
                            <a href="{{ url( $notification->data['url'] ) }}">
                            @elseif(isset($notification->data['id']))
							<a href="{{ route('employee.show',$notification->data['id']) }}">
							@else
							<a href="{{ route('employee.show',Auth::user()->employee_id) }}">
							@endif
								<div class="media ">
									<div class="media-body">
										<h5 class="notification-user">
											{{ $notification->data['title'] }}</h5>
										<p class="notification-msg">{{ $notification->data['data'] }}</p>
										<span class="notification-time">{{ date('Y-F-d  h:i A', strtotime($notification->created_at)) }}</span>
									</div>
								</div>
							</a>
						</li>
						@endforeach
					</ul>
				</li>

				<li class="user-profile header-notification">
					<a class="waves-effect waves-light" style="color: white">
						@if(isset( Auth::user()->employee->employee_photo ))
							<img src="{{asset(Auth::user()->employee->employee_photo)}}" class="img-radius" alt="User-Profile-Image">
						@else
							<img src="{{asset('public/assets/images/user_icon.png')}}" class="img-radius" alt="User-Profile-Image">
						@endif
						<span>{{ Auth::user()->name }}</span>
						<i class="ti-angle-down"></i>
					</a>

					<ul class="show-notification profile-notification">
                        <li class="waves-effect waves-light">
							<a href="{{ route('employee.show',Auth::user()->employee_id) }}">
								<i class="ti-user"></i> Profile
							</a>
						</li>
                        <li class="waves-effect waves-light">
                            <a href="{{ url('user/editPassword',Auth::user()->id) }}">
                                <i class="ti-settings"></i> Change Password
                            </a>
                        </li>
						<li class="waves-effect waves-light">
							<form id="logout-form" action="{{ route('logout') }}" method="POST">
								<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
									{{ __('Logout') }}
										@csrf
								</a>
							</form>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>
