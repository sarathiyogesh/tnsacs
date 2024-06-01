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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Rayna API Report</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="javascript:;" id="fetchapi" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Fetch API</a>

					<a href="javascript:;" id="fetchavailability" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Ticket Availablitiy</a>
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
						<form method="GET" action="/report/rayna-api-report">
							<div class="row">
								<div class="col-md-3">
									<div class="d-flex align-items-center position-relative">
										<span class="svg-icon svg-icon-1 position-absolute ms-4">
											<i class="las la-search"></i>
										</span>
										<input type="text" class="form-control form-control-solid ps-14" placeholder="Search Tour ID" id="tour_id" name="tour_id">
									</div>
								</div>
								<div class="col-md-3">
									<div class="d-flex align-items-center position-relative">
										<span class="svg-icon svg-icon-1 position-absolute ms-4">
											<i class="las la-search"></i>
										</span>
										<input type="text" class="form-control form-control-solid ps-14" placeholder="Search Tour Name" id="tour_name" name="tour_name">
									</div>
								</div>
								<div class="col-md-2">
									<button type="submit" class="btn btn-primary btn-sm">Search</button>
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
								@include('reports.rayna-api-report-table')
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
	<script type="text/javascript">
		$(document).ready(function(){

			$(document).on('click', '#fetchapi', function(){
	            var th = $(this);
	            th.text('Please wait...');
	            $.ajax({
	                url: '/rayna/tour/list',
	                data: null,
	                dataType: 'json',
	                type: 'GET',
	                success: function (res){
	                    if(res.status == 'success'){
	                        var total = "{{ $total }}";
	                        gettouroptions(0, 10, parseInt(total));
	                    }else{
	                        alert(res.message);
	                    }
	                    return false;
	                }, error: function(e){
	                    th.text('Fetch API');
	                    alert(e.responseText);
	                    return false;
	                }
	            });
	        });

	        function gettouroptions(skip, take, total){
	            $.ajax({
	                url: '/rayna/tour/option',
	                data: {skip: skip, take: take, total: total},
	                dataType: 'json',
	                type: 'GET',
	                success: function (res){
	                    if(res.status == 'success'){
	                        if(skip < total){
	                            skip = skip + 10;
	                            gettouroptions(skip, 10, total);
	                        }else{
	                            $('#fetchapi').text('Fetch API');
	                            alert(res.message);
	                            location.reload();
	                        }
	                    }else{
	                        alert(res.message);
	                    }
	                    return false;
	                }, error: function(e){
	                    th.text('Fetch API');
	                    alert(e.responseText);
	                    return false;
	                }
	            });
	        }

			$(document).on('click', '#fetchavailability', function(){
	            fetchavailability(0, 1, 105);
	        });

	        function fetchavailability(skip, take, total){
	            $.ajax({
	                url: '/rayna/availability/tickets/10',
	                data: {skip: skip, take: take, total: total},
	                dataType: 'json',
	                type: 'GET',
	                success: function (res){
	                    if(res.status == 'success'){
	                        if(skip < total){
	                            skip = skip + 1;
	                            fetchavailability(skip, 1, total);
	                        }else{
	                            alert(res.message);
	                            location.reload();
	                        }
	                    }else{
	                        alert(res.message);
	                    }
	                    return false;
	                }, error: function(e){
	                    th.text('Fetch API');
	                    alert(e.responseText);
	                    return false;
	                }
	            });
	        }

		});

	</script>
@endsection