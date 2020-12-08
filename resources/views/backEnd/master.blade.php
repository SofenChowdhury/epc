<!DOCTYPE html>
<html lang="en">
<head>
	@include('backEnd.partials.header')
	@yield('styles')
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
			@include('backEnd.partials.header_top')

			<div class="pcoded-main-container">
				<div class="pcoded-wrapper">
					@include('backEnd.partials.sidebar')
					<div class="pcoded-content">
						<div class="page-header" >
							<div class="page-block" style="background-color: #63bbdc; color: #4599de;">
								<div class="row align-items-center">
									<div class="col-md-8">
										<div class="page-header-title">
{{--                                            <a href="{{ URL::previous() }}" style=" padding: 5px 25px; margin-top: 8px; color: white;" class="back_btn btn btn-success"> Back </a>--}}
{{--											<h5 class="m-b-10">Dashboard</h5>--}}
{{--											<p class="m-b-0">Welcome to ERP</p>--}}
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="pcoded-inner-content">
							<div class="main-body">
								<div class="page-wrapper">
									<div class="page-body">
										@yield('mainContent')
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@include('backEnd.partials.footer')
@yield('javascript')
</body>
</html>
