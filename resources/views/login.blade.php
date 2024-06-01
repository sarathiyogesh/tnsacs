<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="../../../">
		<title>Tamil Nadu State AIDS Control Society</title>
		<meta charset="utf-8" />
		<meta name="description" content="Bharath Gyan ™ Indian Knowledge System Pvt. Ltd" />
		<meta name="keywords" content="Bharath Gyan ™ Indian Knowledge System Pvt. Ltd" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Bharath Gyan ™ Indian Knowledge System Pvt. Ltd" />
		<meta property="og:url" content="https://Bharath Gyan ™ Indian Knowledge System Pvt. Ltd.com/" />
		<meta property="og:site_name" content="Bharath Gyan ™ Indian Knowledge System Pvt. Ltd" />
		<link rel="canonical" href="https://bgiks.com/" />
		<link rel="shortcut icon" href="{ asset('/frontend/images/favicon.png') }}" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="bg-body">
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-cover bgi-attachment-scroll" style="background-image: url({{ asset('media/section-01.jpg') }}">
				<!--begin::Content-->
				<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
					<!--begin::Logo-->
					<a href="javascript:;" class="mb-12">
						<img alt="Logo" src="{!! asset('frontend/images/logo.png') !!}" class="h-80px" />
					</a>
					<!--end::Logo-->
					 @if(!Session::has('loggedIn'))
					<!--begin::Wrapper-->
					<div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-10 mx-auto">
						{!! Helpers::displaymsg() !!}
						<!--begin::Form-->
						<form class="form w-100"  action="{{route('savelogin')}}" method="POST">
							@csrf
							<!--begin::Heading-->
							<div class="text-center mb-10">
								<h2 class="text-dark mb-2">Admin Login</h2>
							</div>
							<!--begin::Heading-->
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<label class="form-label fs-6 fw-bolder text-dark">Email</label>
								<input class="form-control form-control-lg form-control-solid" type="text" name="email" autocomplete="off" value="{{old('email')}}" />
								<!--end::Input-->
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<div class="d-flex flex-stack mb-2">
									<label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
									{{-- <a href="javascript:;" class="text-primary fs-7 fw-bolder">Forgot Password ?</a> --}}
								</div>
								<input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" value="{{old('password')}}" />
							</div>
							<!--end::Input group-->
							<!--begin::Actions-->
							<div class="text-center">
								<!--begin::Submit button-->
								<button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-0">
									<span class="indicator-label">Continue</span>
									<span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								</button>
							</div>
							<!--end::Actions-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Wrapper-->
					@endif
					@if(Session::has('loggedIn') && Session::get('loggedIn') == 'yes')
					<!--begin::Login OTP-->
					<div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-10 mx-auto">
						{!! Helpers::displaymsg() !!}
						<!--begin::Form-->
						<form class="form w-100"  action="{{route('loginwithotp')}}" method="POST">
							@csrf
							<!--begin::Heading-->
							<div class="text-center mb-10">
								<h2 class="text-dark mb-2">OTP</h2>
							</div>
							<!--begin::Heading-->
							<!--begin::Input group-->
							<input type="hidden" name="email" id="email" value="{{old('email')}}">
							<input type="hidden" name="password" id="password" value="{{old('password')}}">
							<div class="fv-row mb-10">
								<label class="form-label fs-6 fw-bolder text-dark">Enter OTP</label>
								<input class="form-control form-control-lg form-control-solid" type="text" name="otp" id="otp" autocomplete="off" />
								<div class="help-block">OTP sent to <b>{{ old('email') }}</b></div>
							</div>
							<!--end::Input group-->
							<!--begin::Actions-->
							<div class="text-center">
								<!--begin::Submit button-->
								<button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-0">
									<span class="indicator-label">Continue</span>
									<span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								</button>
							</div>
							<!--end::Actions-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Login OTP-->
					@endif
				</div>
				<!--end::Content-->
				<!--begin::Footer-->
				<!-- <div class="d-flex flex-center flex-column-auto p-10"> -->
					<!--begin::Links-->
					<!-- <div class="d-flex align-items-center fw-bold fs-6"> -->
						<!-- <a href="https://keenthemes.com" class="text-muted text-hover-primary px-2">About</a>
						<a href="mailto:support@keenthemes.com" class="text-muted text-hover-primary px-2">Contact</a>
						<a href="https://1.envato.market/EA4JP" class="text-muted text-hover-primary px-2">Contact Us</a> -->
					<!-- </div> -->
					<!--end::Links-->
				<!-- </div> -->
				<!--end::Footer-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
		<!--end::Root-->
		<!--end::Main-->
		<!--begin::Javascript-->
		<!-- <script>var hostUrl = "/assets";</script> -->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('js/scripts.bundle.js') }}"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="{{ asset('js/custom/authentication/sign-in/general.js') }}"></script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>