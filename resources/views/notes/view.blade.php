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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Manage Notes</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					
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
									<input type="text" name="search_filter" id="search_filter" class="form-control form-control-solid ps-14" placeholder="Note">
								</div>
							</div>
							<!-- <div class="col-md-2">
								<button type="button" class="btn btn-primary btn-sm">Search</button>
							</div> -->
						</div>
					</div>
				</div>

				<div class="card card-flush">
					<!--begin::Card body-->
					<div class="card-body">
						<!--begin::Table-->
						<div class="alert alert-success successMsg-show" style="display:none;"></div>
						<div class="alert alert-danger errorMsg-show" style="display:none;"></div>
						<div id="kt_ecommerce_products_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
							<div class="table-responsive showTable">
								<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="contact-message-table">
									<!--begin::Table head-->
									<thead>
										<!--begin::Table row-->
										<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
											<th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Institution</th>
											<th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Faculty</th>
											<th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Course</th>
											<th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Last updated on</th>
											<th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Status</th>
										   <th class="min-w-70px" rowspan="1" colspan="1">Actions</th>
										</tr>
										<!--end::Table row-->
									</thead>
									<!--end::Table head-->
									<!--begin::Table body-->
									<tbody>
										<tr>
											<td>ABC Institution</td>
											<td>John Doe</td>
											<td>Tamil Ariviyal</td>
											<td>21/02/2024</td>
											<td>Active</td>
											<td><a href="javascript:;" class="actionLink"><i class="las la-edit"></i> View</a></td>
										</tr>
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
	</div>
	<!--end::Content-->
@endsection

@section('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			//getTable();
			$('#kt_help').show();

			$(document).on('keyup', '#search_filter', function(){
				getTable();
			});

			function getTable(){
				var search = $('#search_filter').val();
				$('.errorMsg-show').html('').hide();
				$.ajax({
	                url:"{{ url('/master/category/view') }}",
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


			$(document).on('click', '.deleteCategoryBtn', function (){
				if(confirm('Are you sure want to delete?')){
					var id = $(this).attr('data-id');
					var t = $(this); ctxt = t.text();
					t.text('Processing...').prop('disabled', true);
					$('.validation-errors').remove();
					$.ajax({
		                url:"{{ url('/master/category/delete') }}",
		                dataType: 'json',
						headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'), },
		                data: { id:id },
		                type:"POST",
		                success: function(res){
		                	t.text(ctxt).prop('disabled', false);;
		                    if(res.status == 'success'){
		                    	alert('Category deleted successfully');
		                    	getTable();
		                    }else if(res.status == 'error'){
		                    	alert(res.msg);
		                    }
		                },error: function(e){
		                	t.text(ctxt).prop('disabled', false);;
		                	alert(e.responseText);
		                }
		            });
				}
			});

		});

	</script>
@endsection