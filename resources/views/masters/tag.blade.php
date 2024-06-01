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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Manage Tag</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				@can('tags-add')
					<div class="d-flex align-items-center gap-2 gap-lg-3">
						<a href="javascript:;" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addNewTagModel">Add Tag</a>
					</div>
				@endcan
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
									<input type="text" name="search_filter" id="search_filter" class="form-control form-control-solid ps-14" placeholder="Tag Name">
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
								
							</div>
						</div>
					</div>
					<!--end::Card body-->
				</div>
			</div>
		</div>
		<!--end::Post-->

		<!-- Modal -->
		<div class="modal fade" id="addNewTagModel" tabindex="-1" aria-labelledby="addNewTagModelLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Add Tag</h5>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">
		        <form id="tagForm">
				<!--begin::Body-->
				<div class="card-body" id="kt_help_body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="required form-label">Name</label>
								<input type="text" name="tag_name" id="tag_name" class="form-control" placeholder="Tag Name" value="">
							</div>
						</div>
					</div>
				</div>
				<!--end::Body-->
			</form>
		      </div>
		      <div class="modal-footer">
				<button type="button" class="btn btn-primary" id="saveTag">Add</button>
		      </div>
		    </div>
		  </div>
		</div>


		<div class="modal fade" id="editTagModal" tabindex="-1" aria-labelledby="editTagModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Edit Tag</h5>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">
		        <form id="updatetagForm">
				<!--begin::Body-->
				<div class="card-body" id="kt_help_body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="required form-label">Name</label>
								<input type="text" name="edit_tag_name" id="edit_tag_name" class="form-control" placeholder="Tag Name" value="">
							</div>
							<input type="hidden" name="edit_id" id="edit_id" value="">
						</div>
					</div>
				</div>
				<!--end::Body-->
			</form>
		      </div>
		      <div class="modal-footer">
				<button type="button" class="btn btn-primary" id="updateTag">Update</button>
		      </div>
		    </div>
		  </div>
		</div>

	</div>
	<!--end::Content-->
@endsection

@section('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			getTable();
			$('#kt_help').show();

			$(document).on('keyup', '#search_filter', function(){
				getTable();
			});

			$(document).on('click', '#saveTag', function (){
				var data = $('#tagForm').serialize();
				var t = $(this); ctxt = t.text();
				t.text('Processing...').prop('disabled', true);
				$('.validation-errors').remove();
				$.ajax({
	                url:"{{ url('/master/tag/add') }}",
	                dataType: 'json',
					headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'), },
	                data: data,
	                type:"POST",
	                success: function(res){
	                	t.text(ctxt).prop('disabled', false);;
	                    if(res.status == 'success'){
	                    	alert('New tag created successfully');
	                    	$('#addNewTagModel').modal('hide');
	                    	getTable();
	                    }else if(res.status == 'error'){
	                    	alert(res.msg);
	                    }else if(res.status == 'validation'){
	                    	var valid = res.msg;
	                        $.each(valid, function(e,v){
	                            $('#'+e).after('<span class="help-block validation-errors">'+v[0]+'</span>');
	                        });
	                    }
	                },error: function(e){
	                	t.text(ctxt).prop('disabled', false);;
	                	alert(e.responseText);
	                }
	            });
			});

			$(document).on('click', '.editTagBtn', function (){
				$('#edit_id').val($(this).attr('data-id'));
				$('#edit_tag_name').val($(this).attr('data-val'));
				$('#editTagModal').modal('show');
			});

			$(document).on('click', '#updateTag', function (){
				var data = $('#updatetagForm').serialize();
				var t = $(this); ctxt = t.text();
				t.text('Processing...').prop('disabled', true);
				$('.validation-errors').remove();
				$.ajax({
	                url:"{{ url('/master/tag/update') }}",
	                dataType: 'json',
					headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'), },
	                data: data,
	                type:"POST",
	                success: function(res){
	                	t.text(ctxt).prop('disabled', false);;
	                    if(res.status == 'success'){
	                    	alert('Tag name updated successfully');
	                    	$('#editTagModal').modal('hide');
	                    	getTable();
	                    }else if(res.status == 'error'){
	                    	alert(res.msg);
	                    }else if(res.status == 'validation'){
	                    	var valid = res.msg;
	                        $.each(valid, function(e,v){
	                            $('#'+e).after('<span class="help-block validation-errors">'+v[0]+'</span>');
	                        });
	                    }
	                },error: function(e){
	                	t.text(ctxt).prop('disabled', false);;
	                	alert(e.responseText);
	                }
	            });
			});

			$(document).on('click', '.deleteTagBtn', function (){
				if(confirm('Are you sure want to delete?')){
					var id = $(this).attr('data-id');
					var t = $(this); ctxt = t.text();
					t.text('Processing...').prop('disabled', true);
					$('.validation-errors').remove();
					$.ajax({
		                url:"{{ url('/master/tag/delete') }}",
		                dataType: 'json',
						headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'), },
		                data: { id:id },
		                type:"POST",
		                success: function(res){
		                	t.text(ctxt).prop('disabled', false);;
		                    if(res.status == 'success'){
		                    	alert('Tag deleted successfully');
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

			function getTable(){
				var search = $('#search_filter').val();
				$('.errorMsg-show').html('').hide();
				$.ajax({
	                url:"{{ url('/master/tag/view') }}",
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