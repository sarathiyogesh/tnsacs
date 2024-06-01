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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Manage Blog Categories</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				
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
						<div class="row d-flex justify-content-between">
							<div class="col-md-4">
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
							@can('blogs-category-add')
								<div class="col-md-6">
									<div class="d-flex justify-content-end gap-2 gap-lg-3">
									<a href="javascript:;" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addNewCategory">Add Category</a>
									</div>
								</div>
							@endcan
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
		<div class="modal fade" id="addNewCategory" tabindex="-1" aria-labelledby="addNewCategoryLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">
		        <form id="CategoryForm">
				<!--begin::Body-->
				<div class="card-body" id="kt_help_body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="required form-label">Category Name</label>
								<input type="text" name="name" id="cat_name" class="form-control" placeholder="Category name" value="">
							</div>
						</div>
					</div>
				</div>
				<!--end::Body-->
			</form>
		      </div>
		      <div class="modal-footer">
		        <button type="reset" class="btn btn-light btn-active-light-primary me-2 categoryResetBtn">Reset</button>
				<button type="button" class="btn btn-primary" id="saveCategory">Save</button>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- Edit Category -->
		<div class="modal fade" id="EditCategory" tabindex="-1" aria-labelledby="EditCategoryLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">
		        <form id="CategoryForm">
				<!--begin::Body-->
				<div class="card-body" id="kt_help_body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="required form-label">Category Name</label>
								<input type="text" name="name" id="editcat_name" class="form-control" placeholder="Category name" value="">
							</div>
						</div>
					</div>
				</div>

				<input type="hidden" name="category_id" id="category_id">
				<!--end::Body-->
			</form>
		      </div>
		      <div class="modal-footer">
		        <button type="reset" class="btn btn-light btn-active-light-primary me-2 categoryResetBtn">Reset</button>
				<button type="button" class="btn btn-primary" id="updateCategory">Save Changes</button>
		      </div>
		    </div>
		  </div>
		</div>
		
	</div>
	<!--end::Content-->
	<input type="text" style="display:none;" name="hiddenClipboard" id="hiddenClipboard" value="">
@endsection

@section('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			getTable();
			$('#kt_help').show();

			
			

			$(document).on('keyup', '#search_filter', function(){
				getTable();
			});

			$(document).on('click', '#saveCategory', function (){
				var name = $('#cat_name').val();
				var type = "parent";
				$('.validation-errors').remove();
				$('.errorMsg-show').html('').hide();
				$('.successMsg-show').html('').hide();
				$.ajax({
	                url:"{{ url('blogs/category/save') }}",
	                dataType: 'json',
					headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'), },
	                data: {name:name, type:type},
	                type:"POST",
	                success: function(res){
	                    if(res.status == 'success'){
	                    	alert('New Category is created successfully.');
	                    	$('#addNewCategory').modal('hide');
	                    	location.reload();
	                    	// $('#categoryForm')[0].reset();
	                    	// $('.successMsg-show').html('New corporate details has been created successfully').show();
	                    }else if(res.status == 'error'){
	                    	$('#addNewCategory').modal('hide');
	                    	$('.errorMsg-show').html(res.msg).show();
	                    }else if(res.status == 'validation'){
	                    	var valid = res.msg;
	                        $.each(valid, function(e,v){
	                            $('#cat_name').after('<span class="help-block validation-errors">'+v[0]+'</span>');
	                        });
	                    }
	                },error: function(e){
	                    $('.errorMsg-show').html(e.responseText).show();
	                }
	            });
			});

			

			function getTable(){
				var search = $('#search_filter').val();
				$('.errorMsg-show').html('').hide();
				$.ajax({
	                url:"{{ url('blogs/getcategory') }}",
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

			$(document).on('click', '.categoryResetBtn', function(){
				$('#cat_name').val("");
				return false;
			});

			$(document).on('click', '.deleteCategory', function(){
				var click = $(this);
				var id = click.attr('data-id');
				bootbox.confirm("Do you want to delete this category?", function(result){
	                if(result == true){
	                    $.ajax({
				            url: '/blogs/category/delete',
				            data: { category_id:id },
				            dataType: 'json',
				            type: 'GET',
				            success: function(res){
				                if(res.status == 'success'){
				                    click.closest('tr').remove();
				                    bootbox.alert(res.message);
				                    location.reload();
				                }else{
				                	bootbox.alert(res.message);
				                }
				                return false;
				            }, error: function(e){
				                console.log(e.responseText);
				                return false;
				            }
				        });
	                }
	            });
			});

			$(document).on('click', '.editCategoryLink', function(){
				var category_id = $(this).attr('data-id');
				var name = $(this).closest('tr').find(".categoryNameTd").text();
				$('#editcat_name').val(name);
				$('#category_id').val(category_id);
				$('#EditCategory').modal('show');
				return false;
			});

			$(document).on('click', '#updateCategory', function(){
				var name = $('#editcat_name').val();
				var type = "parent";
				var category_id = $('#category_id').val();
				$('.validation-errors').remove();
				$('.errorMsg-show').html('').hide();
				$('.successMsg-show').html('').hide();
				$.ajax({
	                url:"{{ url('blogs/category/update') }}",
	                dataType: 'json',
					headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'), },
	                data: {name:name, type:type, category_id:category_id},
	                type:"POST",
	                success: function(res){
	                    if(res.status == 'success'){
	                    	alert('Category is updated successfully.');
	                    	$('#EditCategory').modal('hide');
	                    	location.reload();
	                    	// $('#categoryForm')[0].reset();
	                    	// $('.successMsg-show').html('New corporate details has been created successfully').show();
	                    }else if(res.status == 'error'){
	                    	$('#EditCategory').modal('hide');
	                    	$('.errorMsg-show').html(res.msg).show();
	                    }else if(res.status == 'validation'){
	                    	var valid = res.msg;
	                        $.each(valid, function(e,v){
	                            $('#editcat_name').after('<span class="help-block validation-errors">'+v[0]+'</span>');
	                        });
	                    }
	                },error: function(e){
	                    $('.errorMsg-show').html(e.responseText).show();
	                }
	            });
			});

		});

		

	</script>
@endsection