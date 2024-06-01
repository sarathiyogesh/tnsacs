@extends("master")
@section('styles')
<style type="text/css">
	.selectiveForm .selectDiv:after {margin-top:-6px;}
</style>
@endsection
@section('maincontent')
	<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<!--begin::Toolbar-->
		<div class="toolbar" id="kt_toolbar">
			<!--begin::Container-->
			<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
				<!--begin::Page title-->
				<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
					<!--begin::Title-->
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">View All Courses</h1>
					<!--end::Title-->
				</div>
			</div>
			<!--end::Container-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Post-->
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<div id="kt_content_container" class="container-xxl">

				<div class="card card-flush mb-4 selectiveForm">
					<div class="card-header py-5 gap-2 gap-md-5">
						<div class="card-header-title">Search by Filter</div>
						<div class="row">
							<div class="col-md-3">
								<div class="selectDiv">
									<select name="status" class="form-control form-select-solid">
										<option value="1">Category</option>
										<option value="1">Indian History</option>
										<option value="0">Tamil Ariviyal</option>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="selectDiv">
									<select name="status" class="form-control form-select-solid">
										<option value="1">Subject</option>
										<option value="1">Tamil</option>
										<option value="0">English</option>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="selectDiv">
									<select name="status" class="form-control form-select-solid">
										<option value="1">Status</option>
										<option value="1">Active</option>
										<option value="0">Inactive</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="d-flex align-items-center position-relative">
									<span class="svg-icon svg-icon-1 position-absolute ms-4">
										<i class="las la-search"></i>
									</span>
									<input type="text" class="form-control form-control-solid ps-14" placeholder="Search by Course Name" id="search_filter" name="search_filter">
								</div>
							</div>
							<div class="col-md-2">
								<button type="submit" class="btn btn-dark btn-sm w-100">Search</button>
							</div>
						</div>
					</div>
				</div>

				<div class="card card-flush">
					<!--begin::Card body-->
					<div class="card-body">
						<div class="row d-flex justify-content-end mb-3">
							<div class="col-md-6 filters">
								<div class="d-flex align-items-center justify-content-end">
									<div class="me-3">Sort By:</div>
									<div>
										<a href="javascript:;" class="active"><i class="las la-border-all"></i></a>
										<a href="javascript:;"><i class="las la-list"></i></a>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="course-container">
									<div class="course-status active"><img src="{{URL::asset('media/icons/active.png')}}"></div>
									<div><a href="{{ url('/courses/view-course') }}"><img src="{{URL::asset('media/course-1.jpg')}}" class="image"></a></div>
									<div class="course-inner">
										<h4>Tamil Ariviyal</h4>
										<div class="section-text">
											Lorem ipsum dolor sit amet, consectetur adipisicing elit...
										</div>
										<hr>
										<div class="btn btn-success btn-xs"><i class="las la-check-circle"></i> Purchased</div>
										<div class="course-fee mb-1 mt-2">1st Semester (Jan to June) - <i class="las la-rupee-sign"></i> 10,000</div>
										<div class="fs-8 text-success fw-bolder">Subscribed till June 2024</div>
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="course-container">
									<div class="course-status renew"><img src="{{URL::asset('media/icons/renew.png')}}"></div>
									<div><a href="{{ url('/courses/view-course') }}"><img src="{{URL::asset('media/course-2.jpg')}}" class="image"></a></div>
									<div class="course-inner">
										<h4>Water Harnessing</h4>
										<div class="section-text">
											Lorem ipsum dolor sit amet, consectetur adipisicing elit...
										</div>
										<hr>
										<div class="btn btn-warning btn-xs"><i class="las la-clock"></i> Renew</div>
										<div class="course-fee mb-1 mt-2">1st Semester (Jan to June) - <i class="las la-rupee-sign"></i> 10,000</div>
										<div class="fs-8 text-danger fw-bolder">Ends in 30 Days</div>
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="course-container">
									<div class="course-status addcart"><img src="{{URL::asset('media/icons/cart.png')}}"></div>
									<div><a href="{{ url('/courses/course-overview') }}"><img src="{{URL::asset('media/course-3.jpg')}}" class="image"></a></div>
									<div class="course-inner">
										<h4>Computer Networks</h4>
										<div class="section-text">
											Lorem ipsum dolor sit amet, consectetur adipisicing elit...
										</div>
										<hr>
										<div class="btn btn-primary-light btn-xs"><i class="las la-cart-plus"></i> Add to Cart</div>
										<div class="course-fee mb-1 mt-2">1st Semester (Jan to June) - <i class="las la-rupee-sign"></i> 10,000</div>
										<div class="fs-8 text-danger fw-bolder">&nbsp;</div>
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="course-container">
									<div class="course-status renew"><img src="{{URL::asset('media/icons/renew.png')}}"></div>
									<div><a href="{{ url('/courses/view-course') }}"><img src="{{URL::asset('media/course-4.jpg')}}" class="image"></a></div>
									<div class="course-inner">
										<h4>Learning Theories</h4>
										<div class="section-text">
											Lorem ipsum dolor sit amet, consectetur adipisicing elit...
										</div>
										<hr>
										<div class="btn btn-warning btn-xs"><i class="las la-clock"></i> Renew</div>
										<div class="course-fee mb-1 mt-2">1st Semester (Jan to June) - <i class="las la-rupee-sign"></i> 10,000</div>
										<div class="fs-8 text-danger fw-bolder">Ends in 7 Days</div>
									</div>
								</div>
							</div>


						</div>

						<div class="custom-pagination pagination">
							<div class="custom-pagination pagination">
							   <nav>
							      <ul class="pagination">
							         <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
							            <span class="page-link" aria-hidden="true">‹</span>
							         </li>
							         <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
							         <li class="page-item"><a class="page-link" href="javascript:;">2</a></li>
							         <li class="page-item"><a class="page-link" href="javascript:;">3</a></li>
							         <li class="page-item">
							            <a class="page-link" href="javascript:;" rel="next" aria-label="Next »">›</a>
							         </li>
							      </ul>
							   </nav>
							</div>
						</div>
					</div>
					<!--end::Card body-->
				</div>
			</div>
		</div>
		<!--end::Post-->

		<!--end::Help drawer-->
	</div>
	<!--end::Content-->
@endsection

@section('scripts')
	
@endsection