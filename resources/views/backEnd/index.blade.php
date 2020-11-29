<!DOCTYPE html>
<html lang="en">
<head>
	<title>Mega Able bootstrap admin template by Phoenixcoded</title>
  <!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="Gradient Able Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
  <meta name="keywords" content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
  <meta name="author" content="Phoenixcoded" />

  <link rel="icon" href="http://html.phoenixcoded.net/mega-able/files/assets/images/favicon.ico" type="image/x-icon">

  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">


  <link rel="stylesheet" type="text/css" href="{{asset('public/bower_components/bootstrap/css/bootstrap.min.css')}}">

  <link rel="stylesheet" href="{{asset('public/assets/pages/waves/css/waves.min.css')}}" type="text/css" media="all">

  <link rel="stylesheet" type="text/css" href="{{asset('public/assets/icon/themify-icons/themify-icons.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/jquery.mCustomScrollbar.css')}}">

  <!-- <link rel="stylesheet" href="www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" /> -->

  <link rel="stylesheet" href="{{asset('public/assets/pages/chart/radial/css/radial.css')}}" type="text/css" media="all">

  <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/style.css')}}">
</head>
<body>

	<div class="theme-loader">
		<div class="loader-track">
			<div class="preloader-wrapper">
				<div class="spinner-layer spinner-blue">
					<div class="circle-clipper left">
						<div class="circle"></div>
					</div>
					<div class="gap-patch">
						<div class="circle"></div>
					</div>
					<div class="circle-clipper right">
						<div class="circle"></div>
					</div>
				</div>
				<div class="spinner-layer spinner-red">
					<div class="circle-clipper left">
						<div class="circle"></div>
					</div>
					<div class="gap-patch">
						<div class="circle"></div>
					</div>
					<div class="circle-clipper right">
						<div class="circle"></div>
					</div>
				</div>
				<div class="spinner-layer spinner-yellow">
					<div class="circle-clipper left">
						<div class="circle"></div>
					</div>
					<div class="gap-patch">
						<div class="circle"></div>
					</div>
					<div class="circle-clipper right">
						<div class="circle"></div>
					</div>
				</div>
				<div class="spinner-layer spinner-green">
					<div class="circle-clipper left">
						<div class="circle"></div>
					</div>
					<div class="gap-patch">
						<div class="circle"></div>
					</div>
					<div class="circle-clipper right">
						<div class="circle"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="pcoded" class="pcoded">
		<div class="pcoded-overlay-box"></div>
		<div class="pcoded-container navbar-wrapper">
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
						<a href="index-2.html">
							<img class="img-fluid" src="{{asset('public/assets/images/logo_1.png')}}" alt="Theme-Logo" height="25" width="157" />
						</a>
						<a class="mobile-options waves-effect waves-light">
							<i class="ti-more"></i>
						</a>
					</div>
					<div class="navbar-container container-fluid">
						<ul class="nav-left">
							<li>
								<div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
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
									<i class="ti-fullscreen"></i>
								</a>
							</li>
						</ul>
						<ul class="nav-right">
							<li class="header-notification">
								<a href="#!" class="waves-effect waves-light">
									<i class="ti-bell"></i>
									<span class="badge bg-c-red"></span>
								</a>
								<ul class="show-notification">
									<li>
										<h6>Notifications</h6>
										<label class="label label-danger">New</label>
									</li>

									@foreach(Auth::user()->notifications as $notification)
									<li class="waves-effect waves-light">
										<div class="media">
											<img class="d-flex align-self-center img-radius" src="{{asset('public/assets/images/avatar-2.jpg')}}" alt="Generic placeholder image">
											<div class="media-body">
												<h5 class="notification-user">John Doe</h5>
												<p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
												<span class="notification-time">30 minutes ago</span>
											</div>
										</div>
									</li>
									@endforeach
									<li class="waves-effect waves-light">
										<div class="media">
											<img class="d-flex align-self-center img-radius" src="{{asset('public/assets/images/avatar-4.jpg')}}" alt="Generic placeholder image">
											<div class="media-body">
												<h5 class="notification-user">Joseph William</h5>
												<p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
												<span class="notification-time">30 minutes ago</span>
											</div>
										</div>
									</li>
									<li class="waves-effect waves-light">
										<div class="media">
											<img class="d-flex align-self-center img-radius" src="{{asset('public/assets/images/avatar-3.jpg')}}" alt="Generic placeholder image">
											<div class="media-body">
												<h5 class="notification-user">Sara Soudein</h5>
												<p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
												<span class="notification-time">30 minutes ago</span>
											</div>
										</div>
									</li>
								</ul>
							</li>
							<li class="user-profile header-notification">
								<a class="waves-effect waves-light">
									<img src="{{asset('public/assets/images/avatar-4.jpg')}}" class="img-radius" alt="User-Profile-Image">
									<span>{{ Auth::user()->name }}</span>
									<i class="ti-angle-down"></i>
								</a>
								<ul class="show-notification profile-notification">
									<li class="waves-effect waves-light">
										<a href="">
											<i class="ti-user"></i> Profile
										</a>
									</li>

									<li class="waves-effect waves-light">
										<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
	                                    </a>

	                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	                                        @csrf
	                                    </form>
									</li>

								</ul>
							</li>
						</ul>
					</div>
				</div>
			</nav>

			<div class="showChat_inner">
				<div class="media chat-inner-header">
					<a class="back_chatBox">
						<i class="fa fa-chevron-left"></i> Josephin Doe
					</a>
				</div>
				<div class="media chat-messages">
					<a class="media-left photo-table" href="#!">
						<img class="media-object img-radius img-radius m-t-5" src="../files/assets/images/avatar-3.jpg" alt="Generic placeholder image">
					</a>
					<div class="media-body chat-menu-content">
						<div class="">
							<p class="chat-cont">I'm just looking around. Will you tell me something about yourself?</p>
							<p class="chat-time">8:20 a.m.</p>
						</div>
					</div>
				</div>
				<div class="media chat-messages">
					<div class="media-body chat-menu-reply">
						<div class="">
							<p class="chat-cont">I'm just looking around. Will you tell me something about yourself?</p>
							<p class="chat-time">8:20 a.m.</p>
						</div>
					</div>
					<div class="media-right photo-table">
						<a href="#!">
							<img class="media-object img-radius img-radius m-t-5" src="../files/assets/images/avatar-4.jpg" alt="Generic placeholder image">
						</a>
					</div>
				</div>
				<div class="chat-reply-box">
					<div class="right-icon-control">
						<form class="form-material">
							<div class="form-group form-primary">
								<input type="text" name="footer-email" class="form-control" required="">
								<span class="form-bar"></span>
								<label class="float-label"><i class="fa fa-search m-r-10"></i>Share Your Thoughts</label>
							</div>
						</form>
						<div class="form-icon ">
							<button class="btn btn-success btn-icon  waves-effect waves-light">
								<i class="fa fa-paper-plane "></i>
							</button>
						</div>
					</div>
				</div>
			</div>

			<div class="pcoded-main-container">
				<div class="pcoded-wrapper">
					@include('backEnd.partials.sidebar')
					<div class="pcoded-content">
						<div class="page-header">
							<div class="page-block">
								<div class="row align-items-center">
									<div class="col-md-8">
										<div class="page-header-title">
											<h5 class="m-b-10">Dashboard</h5>
											<p class="m-b-0">Welcome to ERP</p>
										</div>
									</div>
									<div class="col-md-4">
										<ul class="breadcrumb">
											<li class="breadcrumb-item">
												<a href="index-2.html"> <i class="fa fa-home"></i> </a>
											</li>
											<li class="breadcrumb-item"><a href="">Dashboard</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>

						<div class="pcoded-inner-content">

							<div class="main-body">
								<div class="page-wrapper">

									<div class="page-body">
										<div class="row">

											<div class="col-xl-3 col-md-6">
												<div class="card">
													<div class="card-block">
														<div class="row align-items-center">
															<div class="col-8">
																<h4 class="text-c-purple">$30200</h4>
																<h6 class="text-muted m-b-0">All Earnings</h6>
															</div>
															<div class="col-4 text-right">
																<i class="fa fa-bar-chart f-28"></i>
															</div>
														</div>
													</div>
													<div class="card-footer bg-c-purple">
														<div class="row align-items-center">
															<div class="col-9">
																<p class="text-white m-b-0">% change</p>
															</div>
															<div class="col-3 text-right">
																<i class="fa fa-line-chart text-white f-16"></i>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-xl-3 col-md-6">
												<div class="card">
													<div class="card-block">
														<div class="row align-items-center">
															<div class="col-8">
																<h4 class="text-c-green">290+</h4>
																<h6 class="text-muted m-b-0">Page Views</h6>
															</div>
															<div class="col-4 text-right">
																<i class="fa fa-file-text-o f-28"></i>
															</div>
														</div>
													</div>
													<div class="card-footer bg-c-green">
														<div class="row align-items-center">
															<div class="col-9">
																<p class="text-white m-b-0">% change</p>
															</div>
															<div class="col-3 text-right">
																<i class="fa fa-line-chart text-white f-16"></i>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-xl-3 col-md-6">
												<div class="card">
													<div class="card-block">
														<div class="row align-items-center">
															<div class="col-8">
																<h4 class="text-c-red">145</h4>
																<h6 class="text-muted m-b-0">Task Completed</h6>
															</div>
															<div class="col-4 text-right">
																<i class="fa fa-calendar-check-o f-28"></i>
															</div>
														</div>
													</div>
													<div class="card-footer bg-c-red">
														<div class="row align-items-center">
															<div class="col-9">
																<p class="text-white m-b-0">% change</p>
															</div>
															<div class="col-3 text-right">
																<i class="fa fa-line-chart text-white f-16"></i>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-xl-3 col-md-6">
												<div class="card">
													<div class="card-block">
														<div class="row align-items-center">
															<div class="col-8">
																<h4 class="text-c-blue">500</h4>
																<h6 class="text-muted m-b-0">Downloads</h6>
															</div>
															<div class="col-4 text-right">
																<i class="fa fa-hand-o-down f-28"></i>
															</div>
														</div>
													</div>
													<div class="card-footer bg-c-blue">
														<div class="row align-items-center">
															<div class="col-9">
																<p class="text-white m-b-0">% change</p>
															</div>
															<div class="col-3 text-right">
																<i class="fa fa-line-chart text-white f-16"></i>
															</div>
														</div>
													</div>
												</div>
											</div>
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
																		<th>
																			<div class="chk-option">
																				<div class="checkbox-fade fade-in-primary">
																					<label class="check-task">
																						<input type="checkbox" value="">
																						<span class="cr">
																							<i class="cr-icon fa fa-check txt-default"></i>
																						</span>
																					</label>
																				</div>
																			</div>
																		Assigned</th>
																		<th>Name</th>
																		<th>Due Date</th>
																		<th class="text-right">Priority</th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<td>
																			<div class="chk-option">
																				<div class="checkbox-fade fade-in-primary">
																					<label class="check-task">
																						<input type="checkbox" value="">
																						<span class="cr">
																							<i class="cr-icon fa fa-check txt-default"></i>
																						</span>
																					</label>
																				</div>
																			</div>
																			<div class="d-inline-block align-middle">
																				<img src="{{asset('public/assets/images/avatar-4.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
																				<div class="d-inline-block">
																					<h6>John Deo</h6>
																					<p class="text-muted m-b-0">Graphics Designer</p>
																				</div>
																			</div>
																		</td>
																		<td>Able Pro</td>
																		<td>Jun, 26</td>
																		<td class="text-right"><label class="label label-danger">Low</label></td>
																	</tr>
																	<tr>
																		<td>
																			<div class="chk-option">
																				<div class="checkbox-fade fade-in-primary">
																					<label class="check-task">
																						<input type="checkbox" value="">
																						<span class="cr">
																							<i class="cr-icon fa fa-check txt-default"></i>
																						</span>
																					</label>
																				</div>
																			</div>
																			<div class="d-inline-block align-middle">
																				<img src="{{asset('public/assets/images/avatar-5.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
																				<div class="d-inline-block">
																					<h6>Jenifer Vintage</h6>
																					<p class="text-muted m-b-0">Web Designer</p>
																				</div>
																			</div>
																		</td>
																		<td>Mashable</td>
																		<td>March, 31</td>
																		<td class="text-right"><label class="label label-primary">high</label></td>
																	</tr>
																	<tr>
																		<td>
																			<div class="chk-option">
																				<div class="checkbox-fade fade-in-primary">
																					<label class="check-task">
																						<input type="checkbox" value="">
																						<span class="cr">
																							<i class="cr-icon fa fa-check txt-default"></i>
																						</span>
																					</label>
																				</div>
																			</div>
																			<div class="d-inline-block align-middle">
																				<img src="{{asset('public/assets/images/avatar-5.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
																				<div class="d-inline-block">
																					<h6>William Jem</h6>
																					<p class="text-muted m-b-0">Developer</p>
																				</div>
																			</div>
																		</td>
																		<td>Flatable</td>
																		<td>Aug, 02</td>
																		<td class="text-right"><label class="label label-success">medium</label></td>
																	</tr>
																	<tr>
																		<td>
																			<div class="chk-option">
																				<div class="checkbox-fade fade-in-primary">
																					<label class="check-task">
																						<input type="checkbox" value="">
																						<span class="cr">
																							<i class="cr-icon fa fa-check txt-default"></i>
																						</span>
																					</label>
																				</div>
																			</div>
																			<div class="d-inline-block align-middle">
																				<img src="{{asset('public/assets/images/avatar-5.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
																				<div class="d-inline-block">
																					<h6>David Jones</h6>
																					<p class="text-muted m-b-0">Developer</p>
																				</div>
																			</div>
																		</td>
																		<td>Guruable</td>
																		<td>Sep, 22</td>
																		<td class="text-right"><label class="label label-primary">high</label></td>
																	</tr>
																</tbody>
															</table>
															<div class="text-right m-r-20">
																<a href="#!" class=" b-b-primary text-primary">View all Projects</a>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-xl-4 col-md-12">
												<div class="card ">
													<div class="card-header">
														<h5>Team Members</h5>
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
														<div class="align-middle m-b-30">
															<img src="{{asset('public/assets/images/avatar-2.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
															<div class="d-inline-block">
																<h6>David Jones</h6>
																<p class="text-muted m-b-0">Developer</p>
															</div>
														</div>
														<div class="align-middle m-b-30">
															<img src="{{asset('public/assets/images/avatar-1.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
															<div class="d-inline-block">
																<h6>David Jones</h6>
																<p class="text-muted m-b-0">Developer</p>
															</div>
														</div>
														<div class="align-middle m-b-30">
															<img src="{{asset('public/assets/images/avatar-3.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
															<div class="d-inline-block">
																<h6>David Jones</h6>
																<p class="text-muted m-b-0">Developer</p>
															</div>
														</div>
														<div class="align-middle m-b-30">
															<img src="{{asset('public/assets/images/avatar-4.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
															<div class="d-inline-block">
																<h6>David Jones</h6>
																<p class="text-muted m-b-0">Developer</p>
															</div>
														</div>
														<div class="align-middle m-b-10">
															<img src="{{asset('public/assets/images/avatar-5.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
															<div class="d-inline-block">
																<h6>David Jones</h6>
																<p class="text-muted m-b-0">Developer</p>
															</div>
														</div>
														<div class="text-center">
															<a href="#!" class="b-b-primary text-primary">View all Projects</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<script type="text/javascript" src="{{asset('public/bower_components/jquery/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/bower_components/jquery-ui/js/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/bower_components/popper.js/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/bower_components/bootstrap/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/assets/pages/widget/excanvas.js')}}"></script>

<script src="{{asset('public/assets/pages/waves/js/waves.min.js')}}"></script>

<script type="text/javascript" src="{{asset('public/bower_components/jquery-slimscroll/js/jquery.slimscroll.js')}}"></script>

<script type="text/javascript" src="{{asset('public/bower_components/modernizr/js/modernizr.js')}}"></script>

<script type="text/javascript" src="{{asset('public/assets/js/SmoothScroll.js')}}"></script>
<script src="{{asset('public/assets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>

<script type="text/javascript" src="{{asset('public/bower_components/chart.js/js/Chart.js')}}"></script>

<script src="www.amcharts.com/lib/3/amcharts.js"></script>
<!-- <script src="{{asset('public/assets/pages/widget/amchart/gauge.min.js')}}"></script>
<script src="{{asset('public/assets/pages/widget/amchart/serial.min.js')}}"></script>
<script src="{{asset('public/assets/pages/widget/amchart/light.min.js')}}"></script>
<script src="{{asset('public/assets/pages/widget/amchart/pie.min.js')}}"></script> -->
<!-- <script src="www.amcharts.com/lib/3/plugins/export/export.min.js"></script> -->

<!-- <script src="{{asset('public/')}}../../../developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script> -->
<!-- <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script> -->
<!-- <script type="text/javascript" src="{{asset('asset/public/')}}../files/assets/pages/google-maps/gmaps.js"></script> -->

<script src="{{asset('public/assets/js/pcoded.min.js')}}"></script>
<script src="{{asset('public/assets/js/vertical/vertical-layout.min.js')}}"></script>

<script type="text/javascript" src="{{asset('public/assets/pages/dashboard/custom-dashboard.js')}}"></script>
<script type="text/javascript" src="{{asset('public/assets/js/script.js')}}"></script>
</body>
</html>
