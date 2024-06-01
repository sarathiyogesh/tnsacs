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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Event Report</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{url('eventreport/excel')}}" id="exportActivityReport" class="btn btn-sm btn-primary" >Excel Export</a>
				</div>
				<!--end::Actions-->
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
	                url:"{{ url('geteventreports') }}",
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
	        var url = "/eventreport/excel";
	        var win = window.open(url);
	      	win.focus();
			return false;
	    });

	</script>
@endsection