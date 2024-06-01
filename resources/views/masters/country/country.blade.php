<?php
	use Illuminate\Support\Str;
?>
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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Manage Countries</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				@can('country-add')
					<div class="d-flex align-items-center gap-2 gap-lg-3">
						<a href="javascript:;" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addNewCountryModel" id="addButton">Add Country</a>
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
									<input type="text" name="search_filter" id="search_filter" class="form-control form-control-solid ps-14" placeholder="Country Name">
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
		<div class="modal fade" id="addNewCountryModel" tabindex="-1" aria-labelledby="addNewCountryModelLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Add Country</h5>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">
		        <form id="countryForm">
				<!--begin::Body-->
				<div class="card-body" id="kt_help_body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="required form-label">Country Name</label>
								<input type="text" name="country_name" id="country_name" class="form-control" placeholder="Country Name" value="">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="required form-label">Country Code</label>
								<input type="text" name="country_code" id="country_code" class="form-control" placeholder="Country Code" value="">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="required form-label">Phone Code</label>
								<input type="text" name="phone_code" id="phone_code" class="form-control" placeholder="Phone Code" value="">
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
						<div class="col-md-12">
							<div class="form-group">
								<label class="required form-label">Country Image</label>
								<input type="file" name="country_image" id="country_image" class="form-control" value="">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="required form-label">Country Description</label>
								<textarea rows="3" name="country_description" id="country_description" class="form-control"> </textarea>
							</div>
						</div>
					</div>
				</div>
				<!--end::Body-->
			</form>
		      </div>
		      <div class="modal-footer">
				<button type="button" class="btn btn-primary" id="saveCountry">Add</button>
		      </div>
		    </div>
		  </div>
		</div>


		<div class="modal fade" id="editCountryModal" tabindex="-1" aria-labelledby="editCountryModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Edit Country</h5>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">
		        <form id="updatecountryForm">
				<!--begin::Body-->
				<div class="card-body" id="kt_help_body">
					<input type="hidden" name="edit_id" id="edit_id" value="">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="required form-label">Country Name</label>
								<input type="text" name="edit_country_name" id="edit_country_name" class="form-control" placeholder="Country Name" value="">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="required form-label">Country Code</label>
								<input type="text" name="edit_country_code" id="edit_country_code" class="form-control" placeholder="Country Code" value="">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="required form-label">Phone Code</label>
								<input type="text" name="edit_phone_code" id="edit_phone_code" class="form-control" placeholder="Phone Code" value="">
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
						<div class="col-md-6">
							<div class="form-group">
								<label class="required form-label">Country Image</label>
								<input type="file" name="edit_country_image" id="edit_country_image" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<img id="showImage" style="height:100px; width:100px;" src="" >
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="required form-label">Country Description</label>
								<textarea rows="3" name="edit_country_description" id="edit_country_description" class="form-control"> </textarea>
							</div>
						</div>
					</div>
				</div>
				<!--end::Body-->
			</form>
		      </div>
		      <div class="modal-footer">
				<button type="button" class="btn btn-primary" id="updateCountry">Update</button>
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
			CKEDITOR.replace('country_description');
			CKEDITOR.replace('edit_country_description');
			getTable();
			$('#kt_help').show();

			$(document).on('keyup', '#search_filter', function(){
				getTable();
			});

			$(document).on('click', '#saveCountry', function (){
				var t = $(this); ctxt = t.text();
				t.text('Processing...').prop('disabled', true);
				$('#addNewCountryModel').find('.validation-errors').remove();
				//$('#addNewCountryModel').remove('.validation-errors');
				var form = $('#countryForm')[0];
				var des = CKEDITOR.instances.country_description.getData();
				var fd = new FormData(form);
	            fd.append('country_description', des);
				$.ajax({
	                url:"{{ url('/master/country/add') }}",
	                dataType: 'json',
					headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'), },
	                data: fd,
	                type:"POST",
	                cache : false,
		            contentType: false,
		            processData : false,
	                success: function(res){
	                	t.text(ctxt).prop('disabled', false);;
	                    if(res.status == 'success'){
	                    	alert('New country is added successfully');
	                    	$('#countryForm')[0].reset();
	                    	$('#addNewCountryModel').modal('hide');
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

			$(document).on('click', '.editCountryBtn', function (){
				var id = $(this).attr('data-id');
				$('#edit_id').val(id);
				var country_image = $(this).closest('tr').find("img").attr("src");
				$.ajax({
	                url:"{{ url('/master/country/edit') }}",
	                dataType: 'json',
	                data: {id:id},
	                type:"GET",
	                success: function(res){
	                    if(res.status == 'success'){
	                    	$('#edit_country_name').val(res.record.country_name);
							$('#edit_country_code').val(res.record.country_code);
							$('#edit_phone_code').val(res.record.phone_code);
							$('#showImage').attr("src", country_image);
							CKEDITOR.instances['edit_country_description'].setData(res.record.country_description);
							$('#edit_status').val(res.record.status).change();
							$('#editCountryModal').find('.validation-errors').remove();
							$('#editCountryModal').modal('show');
	                    }else if(res.status == 'error'){
	                    	alert(res.msg);
	                    }
	                },error: function(e){
	                	t.text(ctxt).prop('disabled', false);;
	                	alert(e.responseText);
	                }
	            });

			});

			$(document).on('click', '#updateCountry', function (){
				var t = $(this); ctxt = t.text();
				t.text('Processing...').prop('disabled', true);
				$('#editCountryModal').find('.validation-errors').remove();
				var form = $('#updatecountryForm')[0];
				var des = CKEDITOR.instances.edit_country_description.getData();
				var fd = new FormData(form);
	            fd.append('edit_country_description', des);
				$.ajax({
	                url:"{{ url('/master/country/update') }}",
	                dataType: 'json',
					headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'), },
	                data: fd,
	                type:"POST",
	                cache : false,
		            contentType: false,
		            processData : false,
	                success: function(res){
	                	t.text(ctxt).prop('disabled', false);;
	                    if(res.status == 'success'){
	                    	alert('Country is updated successfully');
	                    	$('#updatecountryForm')[0].reset();
	                    	$('#editCountryModal').modal('hide');
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

			$(document).on('click', '.deleteCountryBtn', function (){
				if(confirm('Are you sure want to delete?')){
					var id = $(this).attr('data-id');
					var t = $(this); ctxt = t.text();
					t.text('Processing...').prop('disabled', true);
					$.ajax({
		                url:"{{ url('/master/country/delete') }}",
		                dataType: 'json',
						headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'), },
		                data: { id:id },
		                type:"POST",
		                success: function(res){
		                	t.text(ctxt).prop('disabled', false);;
		                    if(res.status == 'success'){
		                    	alert('Country is deleted successfully');
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

			// $(document).on('change', '#edit_country_image', function(){
			// 	$('#showImage').removeProp('src').hide();
			// 	$('#showImage').attr('src', URL.createObjectURL(event.target.files[0]));
			// 	return false;
			// })
			$('#editCountryModal').on('change', '#edit_country_image', function() {
				$('#showImage').attr('src', URL.createObjectURL(event.target.files[0]));
				//$('.cancelBtn').show();
				return false;
			});

			function getTable(){
				var search = $('#search_filter').val();
				$('.errorMsg-show').html('').hide();
				$.ajax({
	                url:"{{ url('/master/country/view') }}",
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
				$('#addNewCountryModel').find('.validation-errors').remove();
			});



		});

	</script>
@endsection