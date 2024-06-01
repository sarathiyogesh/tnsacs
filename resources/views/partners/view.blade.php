@extends("master")

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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Manage Orders</h1>
					<!--end::Title-->
				</div>
			</div>
			<!--end::Container-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Post-->
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<div id="kt_content_container" class="container-xxl">

				<div class="card card-flush mb-4">
					<div class="card-header py-5 gap-2 gap-md-5">
						<div class="card-header-title">Search by Filter</div>
						<div class="row">
							<div class="col-md-3">
								<div class="d-flex align-items-center position-relative">
									<span class="svg-icon svg-icon-1 position-absolute ms-4">
										<i class="las la-search"></i>
									</span>
									<input type="text" class="form-control form-control-solid ps-14" placeholder="Order Number" id="search_filter" name="search_filter">
								</div>
							</div>
							<div class="col-md-2">
								<button type="submit" class="btn btn-primary btn-sm">Search</button>
							</div>
						</div>
					</div>
				</div>

				<div class="card card-flush">
					<!--begin::Card body-->
					<div class="card-body">
						<div id="kt_ecommerce_products_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer scroll-x">
							<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="kt_ecommerce_products_table">
								<!--begin::Table head-->
								<thead>
									<!--begin::Table row-->
									<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
									   	<th class="w-10px pe-2" rowspan="1" colspan="1" aria-label="">
									      	<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
									   	</th>
									   	<th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Course Name</th>
									   	<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Category</th>
									   	<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Subject</th>
									   	<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Status</th>
									   	<th class="min-w-70px" rowspan="1" colspan="1">Actions</th>
									</tr>
									<!--end::Table row-->
								</thead>
								<!--end::Table head-->
								<!--begin::Table body-->
								<tbody>
									<tr>
							        	<td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
										<td>Tamil Ariviyal</td>
										<td>Language</td>
										<td>Tamil</td>
										<td><a href="javascript:;" class="btn btn-success btn-xs">Active</a></td>
										<td>
											<a href="javascript:;" title="Edit"><i class="las la-edit fs-4 text-red"></i> View</a>
										</td>
							        </tr>
							        <tr>
							        	<td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
										<td>Water Harnessing </td>
										<td>Fusion</td>
										<td>Science</td>
										<td><a href="javascript:;" class="btn btn-danger btn-xs">Inactive</a></td>
										<td>
											<a href="javascript:;" title="Edit"><i class="las la-edit fs-4 text-red"></i> View</a>
										</td>
							        </tr>
							        <tr>
							        	<td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
										<td>Computer Networks</td>
										<td>Fusion</td>
										<td>Computer</td>
										<td><a href="javascript:;" class="btn btn-danger btn-xs">Active</a></td>
										<td>
											<a href="javascript:;" title="Edit"><i class="las la-edit fs-4 text-red"></i> View</a>
										</td>
							        </tr>
							        <tr>
							        	<td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
										<td>Learning Theories</td>
										<td>Fusion</td>
										<td>Computer</td>
										<td><a href="javascript:;" class="btn btn-danger btn-xs">Active</a></td>
										<td>
											<a href="javascript:;" title="Edit"><i class="las la-edit fs-4 text-red"></i> View</a>
										</td>
							        </tr>
								</tbody>
								<!--end::Table body-->
							</table>

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