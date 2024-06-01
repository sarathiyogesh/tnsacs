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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Manage Events</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
					<div class="d-flex align-items-center gap-2 gap-lg-3">
						<a href="{{url('event/add')}}" id="kt_help_toggle" class="btn btn-sm btn-primary" >New Event</a>
					</div>
				<!--end::Actions-->
			</div>
			<!--end::Container-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Post-->
		@if(Session::has('error'))
			<div class="alert alert-danger errorMsg-show">{!! Session::get('error') !!}</div>
		@endif
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
									<input type="text" class="form-control form-control-solid ps-14" placeholder="Search Event" id="search_filter" name="search_filter">
								</div>
							</div>
							<!-- <div class="col-md-2">
								<button type="submit" class="btn btn-primary btn-sm">Search</button>
							</div> -->
						</div>
					</div>
				</div>

				<div class="card card-flush">
					<!--begin::Card body-->
					<div class="card-body">
						<!--begin::Table-->
						<div class="alert alert-danger errorMsg-show" style="display:none;"></div>
						<div class="alert alert-success successMsg-show" style="display:none;"></div>
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
	<style>
.dropbtn {
  background-color: #04AA6D;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e41;}
</style>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			getTable();

			$(document).on('keyup', '#search_filter', function(){
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
				var search = $('#search_filter').val();
				$.ajax({
	                url:"{{ url('event/view') }}",
	                data: { search:search,  page:page },
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

			$(document).on('click', '.changStatus', function(){
				var event_id = $(this).attr('data-id');
				bootbox.confirm("Do you want to change status?", function(result){
	                if(result == true){
						$.ajax({
			                url:"{{ url('event/changestatus') }}",
			                data: {  event_id:event_id },
			                type:"GET",
			                success: function(res){
			                    if(res.status == 'success'){
			                    	// $('.successMsg-show').html(res.msg).show();
			                    	alert(res.msg);
			                    	location.reload();
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

			});

		});

	</script>
@endsection