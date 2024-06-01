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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Manage Event Categories</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
					<div class="d-flex align-items-center gap-2 gap-lg-3">
						<a href="javascript:;" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addNewCategoryModel" id="addButton">Add Category</a>
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
									<input type="text" name="search_filter" id="search_filter" class="form-control form-control-solid ps-14" placeholder="Category Name">
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
		<div class="modal fade" id="addNewCategoryModel" tabindex="-1" aria-labelledby="addNewCategoryModelLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">
		        <form id="categoryForm">
				<!--begin::Body-->
				<div class="card-body" id="kt_help_body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="required form-label">Category Name</label>
								<input type="text" name="name" id="name" class="form-control" placeholder="Category Name" value="">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="required form-label">Status</label>
								<select name="status" aria-label="Select Status" data-control="select2" data-placeholder="Select Status" class="form-select form-select-solid form-select-lg fw-bold" id="status">
									<option value="">Select Status</option>
									<option value="active" selected>Active</option>
									<option value="inactive">Inactive</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<!--end::Body-->
			</form>
		      </div>
		      <div class="modal-footer">
				<button type="button" class="btn btn-primary" id="saveCategory">Add</button>
		      </div>
		    </div>
		  </div>
		</div>


		<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">
		        <form id="updatecategoryForm">
				<!--begin::Body-->
				<div class="card-body" id="kt_help_body">
					<input type="hidden" name="edit_id" id="edit_id" value="">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="required form-label">Category Name</label>
								<input type="text" name="edit_name" id="edit_name" class="form-control" placeholder="Category Name" value="">
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								<label class="required form-label">Status</label>
								<select name="edit_status" aria-label="Select Status" data-control="select2" data-placeholder="Select Status" class="form-select form-select-solid form-select-lg fw-bold" id="edit_status">
									<option value="">Select Status</option>
									<option value="active" >Active</option>
									<option value="inactive">Inactive</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<!--end::Body-->
			</form>
		      </div>
		      <div class="modal-footer">
				<button type="button" class="btn btn-primary" id="updateCategory">Update</button>
		      </div>
		    </div>
		  </div>
		</div>

	</div>
	<!--end::Content-->
@endsection

@section('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
	<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			getTable();
			$('#kt_help').show();

			$(document).on('keyup', '#search_filter', function(){
				getTable();
			});

			$(document).on('click', '#saveCategory', function (){
				var t = $(this); ctxt = t.text();
				t.text('Processing...').prop('disabled', true);
				$('#addNewCategoryModel').find('.validation-errors').remove();
				//$('#addNewCategoryModel').remove('.validation-errors');
				var form = $('#categoryForm').serialize();
				$.ajax({
	                url:"{{ url('/event/category/add') }}",
	                dataType: 'json',
					headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'), },
	                data: form,
	                type:"POST",
	                success: function(res){
	                	t.text(ctxt).prop('disabled', false);;
	                    if(res.status == 'success'){
	                    	alert('New category is added successfully');
	                    	$('#categoryForm')[0].reset();
	                    	$('#addNewCategoryModel').modal('hide');
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

			$(document).on('click', '.editCategoryBtn', function (){
				var id = $(this).attr('data-id');
				$('#edit_id').val(id);
				$.ajax({
	                url:"{{ url('/event/category/edit') }}",
	                dataType: 'json',
	                data: {id:id},
	                type:"GET",
	                success: function(res){
	                    if(res.status == 'success'){
	                    	$('#edit_name').val(res.record.name);
							$('#edit_status').val(res.record.status).change();
							$('#editCategoryModal').find('.validation-errors').remove();
							$('#editCategoryModal').modal('show');
	                    }else if(res.status == 'error'){
	                    	alert(res.msg);
	                    }
	                },error: function(e){
	                	t.text(ctxt).prop('disabled', false);;
	                	alert(e.responseText);
	                }
	            });

			});

			$(document).on('click', '#updateCategory', function (){
				var t = $(this); ctxt = t.text();
				t.text('Processing...').prop('disabled', true);
				$('#editCategoryModal').find('.validation-errors').remove();
				var form = $('#updatecategoryForm').serialize();
				$.ajax({
	                url:"{{ url('/event/category/update') }}",
	                dataType: 'json',
					headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'), },
	                data: form,
	                type:"POST",
	                success: function(res){
	                	t.text(ctxt).prop('disabled', false);;
	                    if(res.status == 'success'){
	                    	alert('Category is updated successfully');
	                    	$('#updatecategoryForm')[0].reset();
	                    	$('#editCategoryModal').modal('hide');
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
	            return false;
			});

			$(document).on('click', '.deleteCategoryBtn', function (){
				if(confirm('Are you sure want to delete?')){
					var id = $(this).attr('data-id');
					var t = $(this); ctxt = t.text();
					t.text('Processing...').prop('disabled', true);
					$.ajax({
		                url:"{{ url('/event/category/delete') }}",
		                dataType: 'json',
						headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'), },
		                data: { id:id },
		                type:"POST",
		                success: function(res){
		                	t.text(ctxt).prop('disabled', false);;
		                    if(res.status == 'success'){
		                    	alert('Category is deleted successfully');
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
	                url:"{{ url('/event/category/view') }}",
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

			$(document).on('click', '#addButton', function(){
				$('#addNewCategoryModel').find('.validation-errors').remove();
			});



		});

	</script>
@endsection