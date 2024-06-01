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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">API Price Report</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="javascript:;" class="btn btn-sm btn-primary" id="apiPriceExcel" >Export Excel</a>
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
						<!--begin::Search-->
						<form id="formId" method="GET" action="/report/api-price-reports">
							<div class="row">
								<div class="col-md-3">
									<div class="d-flex align-items-center position-relative">
										<span class="svg-icon svg-icon-1 position-absolute ms-4">
											<i class="las la-search"></i>
										</span>
										<input type="text" class="form-control form-control-solid ps-14" placeholder="Search Activity Name" id="search" name="search" value="<?php if(isset($_GET['search']) && $_GET['search'] != ''){ echo $_GET['search']; } ?>">
									</div>
								</div>
								<div class="col-md-4">
									<button type="submit" class="btn btn-primary btn-sm">Search</button>&nbsp;
									<button type="button" class="btn btn-primary btn-sm clearBtn">Clear</button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="card card-flush">
					<!--begin::Card body-->
					<div class="card-body">
						<!--begin::Table-->
						<div class="alert alert-danger errorMsg-show" style="display:none;"></div>
						<div id="kt_ecommerce_products_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
							<div class="table-responsive showTable">
								@include('reports.api-price-report-table')
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){

			$('#date_from, #date_to').datepicker({
				format: 'dd-mm-yyyy'
			});

			$(document).on("click", "#apiPriceExcel", function(){
				var search = $('#search').val();
		        var url = "/apiprice/excel";
		        url = url+'?';
		        if(search != ''){
		          url = url+'&&search='+search;
		        }
		        var win = window.open(url);
		      	win.focus();
				return false;
		    });

		    $(document).on('click', '.clearBtn', function(){
		    	$(':input','#formId')
				  .not(':button, :submit, :reset, :hidden')
				  .val('')
				  .prop('checked', false)
				  .prop('selected', false);
		    	$('#formId')[0].reset();
		    	location.href = '/report/api-price-reports';
		    	return false;
		    });

			

		});

	</script>
@endsection