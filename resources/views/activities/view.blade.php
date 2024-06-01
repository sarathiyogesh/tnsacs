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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Manage Activities</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				@can('activities-add')
					<div class="d-flex align-items-center gap-2 gap-lg-3">
						<a href="javascript:;" id="openActivityModal" class="btn btn-sm btn-primary" >Add Activity</a>
					</div>
				@endcan
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
									<input type="text" class="form-control form-control-solid ps-14" placeholder="Search Activity" id="search_filter" name="search_filter">
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

	<!-- Modal -->
	<div class="modal fade" id="addActivity" tabindex="-1" aria-labelledby="addNewActivityLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Add New Activity</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
			<!--begin::Body-->
			<div class="card-body" id="kt_help_body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="required form-label">Activity Name</label>
							<input type="text" name="name" id="name" class="form-control" placeholder="Activity name" value="">
						</div>
					</div>
				</div>
			</div>
			<!--end::Body-->
	      </div>
	      <div class="modal-footer">
	        <button type="reset" class="btn btn-light btn-active-light-primary me-2">Reset</button>
			<button type="button" class="btn btn-primary" id="saveActivity">Save Changes</button>
	      </div>
	    </div>
	  </div>
	</div>
@endsection

@section('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			getTable();

			$(document).on('click', '#openActivityModal', function(){
				$('#addActivity').modal('show');
				return false;
			});

			$(document).on('click', '#saveActivity', function(){
				var click = $(this);
				click.attr('disabled', true);
				var name = $('#name').val();
				$('.successMsg-show').html('').hide();
				$('.errorMsg-show').html('').hide();
				$.ajax({
	                url:"{{ url('activities/store') }}",
	                data: { activity_name:name },
	                type:"GET",
	                success: function(res){
	                    if(res.status == 'success'){
	                    	$('#addActivity').modal('hide');
	                    	$('.successMsg-show').html(res.msg).show();
	                    	getTable();
	                    }else if(res.status == 'validation'){
	                    	$('.errorMsg-show').html(res.msg).show();
	                    }
	                    click.attr('disabled', false);
	                },error: function(e){
	                	click.attr('disabled', false);
	                    $('.errorMsg-show').html(e.responseText).show();
	                }
	            });
			});


			$(document).on('keyup', '#search_filter', function(){
				getTable();
			});

			$(document).on('click', '.updatefeature', function(){
				var click = $(this);
				var activityid = click.attr('data-activity');
				var city = click.attr('data-city');
				$.ajax({
	                url:"{{ url('activities/updatefeature') }}",
	                data: { activityid:activityid,  city:city },
	                type:"GET",
	                success: function(res){
	                    if(res.status == 'success'){
	                    	click.html(res.value);
	                    	if(res.value = 'yes'){
	                    		click.removeClass("label-danger").addClass('label-success');
	                    	}else{
	                    		click.removeClass("label-success").addClass('label-danger');
	                    	}
	                    }else if(res.status == 'error'){
	                    	$('.errorMsg-show').html(res.msg).show();
	                    }
	                },error: function(e){
	                    $('.errorMsg-show').html(e.responseText).show();
	                }
	            });
			});

			$(document).on('click', '.deleteActivity', function(){
				var click = $(this);
				bootbox.confirm("Do you want to delete this activity?", function(result){
					if(result == true){
						var activityid = click.attr('data-id');
						$.ajax({
			                url:"{{ url('activities/delete') }}",
			                data: { activityid:activityid},
			                type:"GET",
			                success: function(res){
			                    if(res.status == 'success'){
			                    	click.closest('tr').remove();
			                    }else if(res.status == 'error'){
			                    	$('.errorMsg-show').html(res.msg).show();
			                    }
			                },error: function(e){
			                    $('.errorMsg-show').html(e.responseText).show();
			                }
			            });
					}
				});
				return false;
			});

			function getTable(){
				var search = $('#search_filter').val();
				$('.errorMsg-show').html('').hide();
				$.ajax({
	                url:"{{ url('activities/view') }}",
	                data: { search:search },
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

	</script>
@endsection