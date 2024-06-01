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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">CMS Pages</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				
			</div>
			<!--end::Container-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Post-->
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<div id="kt_content_container" class="container-xxl">

				<div class="card card-flush">
					<!--begin::Card body-->
					<div class="card-body">
						<!--begin::Table-->
						<div class="alert alert-danger errorMsg-show" style="display:none;"></div>
						<div id="kt_ecommerce_products_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer scroll-x">
							<div class="table-responsive">
								<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="kt_ecommerce_products_table">
									<!--begin::Table head-->
									<thead>
										<!--begin::Table row-->
										<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
										   	<th>S.No</th>
						                    <th>Page Name</th>
						                    <th>Action</th>
										</tr>
										<!--end::Table row-->
									</thead>
									<!--end::Table head-->
									<!--begin::Table body-->
									<tbody>
										@if(count($pages) > 0)
											<?php $i=1; ?>
								                @foreach($pages as $record)
								                <tr>
								                    <td>{!! $i++ !!}</td>
								                    <td>{!! $record->name !!}</td>
								                    <td>
								                        <a class="recordDetails" href="{!! route('cms.page.content', [$record->id]) !!}"><i class="far fa-edit"></i> Edit</a>
								                    </td>
								                </tr>
							                @endforeach
										@else
											<tr>
												<td colspan="3">No data available</td>
											</tr>
										@endif
									</tbody>
									<!--end::Table body-->
								</table>
								
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
@stop
@section("script")
@stop