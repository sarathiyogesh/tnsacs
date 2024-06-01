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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Activity Report</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{url('activityreport/excel')}}" id="exportActivityReport" class="btn btn-sm btn-primary" >Excel Export</a>
				</div>
				<!--end::Actions-->
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
						<div class="row">
							<div class="col-md-3">
								<div class="d-flex align-items-center position-relative">
									<span class="svg-icon svg-icon-1 position-absolute ms-4">
										<i class="las la-search"></i>
									</span>
									<input type="text" class="form-control form-control-solid ps-14" placeholder="Search Activity name" id="search_filter" name="search_filter">
								</div>
							</div>

							<div class="col-md-3">
								<select name="activity_type" aria-label="Activity Connected Via" data-control="select2" data-placeholder="Activity Connected Via" class="form-select form-select-solid form-select-lg fw-bold" id="activity_type">
									<option value="">Select</option>
									<option value="m">Manual</option>
									<option value="a">Rayna API</option>
									<option value="ph">PrioHub API</option>
								</select>
							</div>

							<div class="col-md-3">
								<select name="status" aria-label="Status" data-control="select2" data-placeholder="Status" class="form-select form-select-solid form-select-lg fw-bold" id="status">
									<option value="">Select Status</option>
									<option value="active">Active</option>
									<option value="inactive">Inactive</option>
									<option value="hide">Hidden</option>
								</select>
							</div>
							<div class="col-md-2">
								<button type="button" class="btn btn-primary btn-sm searchBtn">Search</button>&nbsp;
								<button type="button" class="btn btn-light btn-active-light-primary me-2 resetBtn">Reset</button>
							</div>
						</div>
					</div>
				</div>

				<div class="card card-flush">
					<!--begin::Card body-->
					<div class="card-body">
						<!--begin::Table-->
						<div class="alert alert-danger errorMsg-show" style="display:none;"></div>
						<div id="kt_ecommerce_products_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
							<div class="table-responsive showTable">
								
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
			getTable();

			$(document).on('click', '.searchBtn', function(){
				getTable();
			});

			$(document).on('click', '.pagination a', function(event){
		        event.preventDefault();
		        var page = $(this).attr('href').split('page=')[1];
		        $('li').removeClass('active');
		        $(this).parent().addClass('active');
		        getTable(page);
	    	});

			function getTable(page = 1){
				var activity_type = $('#activity_type').val();
				var status = $('#status').val();
				var search_filter = $('#search_filter').val();
				$.ajax({
	                url:"{{ url('getactivityreports') }}",
	                data: { activity_type:activity_type,  page:page, status:status, search_filter:search_filter },
	                type:"GET",
	                success: function(res){
	                    if(res.status == 'success'){
	                    	$('.showTable').html('').html(res.data);
	                    }else if(res.status == 'error'){
	                    	$('.errorMsg-show').html(res.msg).show();
	                    }
	                },error: function(e){
	                    $('.errorMsg-show').html(e.responseText).show();
	                }
	            });
	            return false;
			}

		});

		$(document).on('click', '.resetBtn', function(){
			location.reload();
		});

		$(document).on("click", "#exportActivityReport", function(){
	    	var activity_type = $('#activity_type').val();
			var status = $('#status').val();
			var search_filter = $('#search_filter').val();
	        var url = "/activityreport/excel";
	        url = url+'?';
	        if(activity_type != ''){
	          url = url+'activity_type='+activity_type;
	        }
	        if(status != ''){
	          url = url+'&&status='+status;
	        }
	        if(search_filter != ''){
	          url = url+'&&search_filter='+search_filter;
	        }
	        var win = window.open(url);
	      	win.focus();
			return false;
	    });

	</script>
@endsection