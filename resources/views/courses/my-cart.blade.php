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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Cart (3)</h1>
					<!--end::Title-->
				</div>
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					
				</div>
			</div>
			<!--end::Container-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Post-->
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<div id="kt_content_container" class="container-xxl">
				<div class="row">
					
					<div class="col-md-9">
						<div class="card card-flush">
							<div class="card-body">
								<h3 class="text-dark">Total Cart Amount: <i class="las la-rupee-sign"></i> 40,000</h3>
								<div id="kt_ecommerce_products_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer scroll-x">
									<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="kt_ecommerce_products_table">
										<!--begin::Table head-->
										<thead>
											<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
											   	<th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Course Name</th>
											   	<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Category</th>
											   	<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Subject</th>
											   	<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Plan</th>
											   	<th class="min-w-70px" rowspan="1" colspan="1">Total</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>
													<div class="d-flex align-items-center">
														<div class="me-3"><img src="{{URL::asset('media/course-1.jpg')}}" class="w-70px"></div>
														<div>Tamil Ariviyal<br><span class="text-muted">#ID2546648</span></div>
													</div>
												</td>
												<td>Language</td>
												<td>Tamil</td>
												<td>1st Sem (Jan to Jun)</td>
												<td>
													<span class="fs-4"><i class="las la-rupee-sign text-dark fs-4"></i> 10,000</span>
												</td>
									        </tr>
									        <tr>
												<td>
													<div class="d-flex align-items-center">
														<div class="me-3"><img src="{{URL::asset('media/course-2.jpg')}}" class="w-70px"></div>
														<div>Water Harnessing <br><span class="text-muted">#ID2232664</span></div>
													</div>
												</td>
												<td>Language</td>
												<td>Tamil</td>
												<td>1st Sem (Jan to Jun)</td>
												<td>
													<span class="fs-4"><i class="las la-rupee-sign text-dark fs-4"></i> 10,000</span>
												</td>
									        </tr>
									        <tr>
												<td>
													<div class="d-flex align-items-center">
														<div class="me-3"><img src="{{URL::asset('media/course-1.jpg')}}" class="w-70px"></div>
														<div>Computer Networks<br><span class="text-muted">#ID65465454</span></div>
													</div>
												</td>
												<td>Language</td>
												<td>Tamil</td>
												<td>1st Sem (Jan to Jun)</td>
												<td>
													<span class="fs-4"><i class="las la-rupee-sign text-dark fs-4"></i> 10,000</span>
												</td>
									        </tr>
										</tbody>
									</table>
								</div>
								
								
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-flush mb-4">
							<div class="card-body">
								<div class="course-fee-container">
									<h4>Coupon Code</h4>
									<form action="#" class="form">
                                        <input placeholder="Coupon code" class="form-control" type="text" required="">
                                        &nbsp;<button type="submit" class="btn btn-primary btn-xs w-100">Apply Coupon</button>
                                    </form>
								</div>
							</div>
						</div>

						<div class="card card-flush">
							<div class="card-body">
								<div class="course-fee-container">
									<h4>Summary</h4>
									<table class="table align-middle table-row-dashed fs-7 gy-2 no-footer">
										<tbody>
											<tr>
												<th>No. of Courses</th>
												<td align="right">6</td>
											</tr>
											<tr>
												<th>Discount</th>
												<td align="right">0.00</td>
											</tr>
											<tr>
												<th class="fs-4">Total to Pay</th>
												<td align="right"><span class="total-fee"><i class="las la-rupee-sign text-dark fs-4"></i> 10,000</span></td>
											</tr>
										</tbody>
									</table>

									<div>
										<a href="javascript:;" class="btn btn-primary-light btn-lg w-100">Pay Now</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--end::Post-->

		<!--end::Help drawer-->
	</div>
	<!--end::Content-->
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#dob').datepicker({
			format: 'dd-mm-yyyy'
		});
</script>


@endsection