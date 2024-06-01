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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Manage Organizations</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				@can('discount-organization-add')
					<div class="d-flex align-items-center gap-2 gap-lg-3">
						<a href="javascript:;" class="btn btn-sm btn-primary" id="createOrg">Add Organization</a>
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
									<input type="text" name="search_filter" id="search_filter" class="form-control form-control-solid ps-14" placeholder="Organization Name">
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
		<div class="modal fade" id="addNewOrg" tabindex="-1" aria-labelledby="addNewOrgLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="OrgModalLabel">Add New Organization</h5>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">
		        <form id="organizationForm">
				<!--begin::Body-->
				<div class="card-body" id="kt_help_body">
					<div class="row">
						<input type="hidden" name="orgId" id="orgId" value="">
						<div class="col-md-6">
							<div class="form-group">
								<label class="required form-label">Organization Name</label>
								<input type="text" name="name" id="name" class="form-control" placeholder="Organization name" value="">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="required form-label">Email</label>
								<input type="text" name="email" id="email" class="form-control" placeholder="Email Address" value="">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="required form-label">Phone</label>
								<input type="text" name="phone" id="phone" class="form-control" placeholder="Phone Number" value="">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="required form-label">Domain</label>
								<input type="text" name="domain" id="domain" class="form-control" placeholder="Organization Website" value="">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="required form-label">Expiry</label>
								<input type="text" name="expiry" id="expiry" class="form-control" placeholder="Select Expiry Date" value="">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="required form-label">Location</label>
								<select name="location" id="location" aria-label="Select Location" class="form-select form-select-solid form-select-lg fw-bold">
									<option value="">Select Location</option>
									@foreach($cities as $ci)
										<option value="{{ $ci->id }}">{{ $ci->name }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label class="form-label">Register through link</label>
								<select name="auto_reg_status" id="auto_reg_status" class="form-select form-select-solid form-select-lg fw-bold">
									<option value="1">Yes</option>
									<option value="0" selected>No</option>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label class="required form-label">Status</label>
								<select name="status" id="status" aria-label="Select Status" data-control="select2" data-placeholder="Select Status" class="form-select form-select-solid form-select-lg fw-bold">
									<option value="1">Active</option>
									<option value="0">Inactive</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<!--end::Body-->
			</form>
		      </div>
		      <div class="modal-footer">
		        <button type="reset" class="btn btn-light btn-active-light-primary me-2">Reset</button>
				<button type="button" class="btn btn-primary" id="saveOrganization">Save Changes</button>
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
	<script type="text/javascript">
		$(document).ready(function(){
			getTable();
			$('#kt_help').show();

			$('#expiry').datepicker({
				format: 'yyyy-mm-dd'
			});

			$(document).on('click', '#createOrg', function(){
				$('#OrgModalLabel').html('Add New Organization');
				$('#orgId').val('');
				$('#addNewOrg').modal('show');
			});

			$(document).on('click','.copyToClipboard', function(){
				$('#hiddenClipboard').val($(this).attr('data-id'));
				coptytoclipboardfunc();
			});

			function coptytoclipboardfunc() {
			  	var copyText = document.getElementById("hiddenClipboard");
			  	copyText.select();
			  	copyText.setSelectionRange(0, 99999);
			  	navigator.clipboard.writeText(copyText.value);
			  	alert("Copied");
			}

			$(document).on('keyup', '#search_filter', function(){
				getTable();
			});

			$(document).on('click', '#saveOrganization', function (){
				var data = $('#organizationForm').serialize();
				$('.validation-errors').remove();
				$('.errorMsg-show').html('').hide();
				$('.successMsg-show').html('').hide();
				$.ajax({
	                url:"{{ url('organzation/save') }}",
	                dataType: 'json',
					headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'), },
	                data: data,
	                type:"POST",
	                success: function(res){
	                    if(res.status == 'success'){
	                    	$('#addNewOrg').modal('hide');
	                    	$('#organizationForm')[0].reset();
	                    	$('.successMsg-show').html(res.message).show();
	                    	getTable();
	                    }else if(res.status == 'error'){
	                    	$('.errorMsg-show').html(res.msg).show();
	                    }else if(res.status == 'validation'){
	                    	var valid = res.msg;
	                        $.each(valid, function(e,v){
	                            $('#'+e).after('<span class="help-block validation-errors">'+v[0]+'</span>');
	                        });
	                    }
	                },error: function(e){
	                    $('.errorMsg-show').html(e.responseText).show();
	                }
	            });
			});

			$(document).on('click', '.editOrganization', function (){
				var click = $(this);
				var id = click.attr('data-id');
				$('.errorMsg-show').html('').hide();
				$.ajax({
	                url:"{{ url('organization/edit') }}",
	                dataType: 'json',
	                data: {id: id},
	                type:"GET",
	                success: function(res){
	                    if(res.status == 'success'){
	                    	var data = res.data;
	                    	$('#orgId').val(data.id);
	                    	$('#name').val(data.name);
	                    	$('#email').val(data.email);
	                    	$('#phone').val(data.phone);
	                    	$('#domain').val(data.domain);
	                    	$('#expiry').val(data.expiry);
	                    	$('#location').val(data.location);
	                    	$('#auto_reg_status').val(data.auto_reg_status);
	                    	$('#status').val(data.status);
	                    	$('#OrgModalLabel').html('Update Organization');
							$('#addNewOrg').modal('show');
	                    }else if(res.status == 'error'){
	                    	$('.errorMsg-show').html(res.msg).show();
	                    }
	                },error: function(e){
	                    $('.errorMsg-show').html(e.responseText).show();
	                }
	            });
			});

			$(document).on('click', '.deleteOrganization', function (){
				var click = $(this);
				var id = click.attr('data-id');
				$('.errorMsg-show').html('').hide();
				$('.successMsg-show').html('').hide();
				var con = confirm('Are you sure to delete this organization? This cannot be undone!');
				if(con){
					$.ajax({
		                url:"{{ url('organization/delete') }}",
		                dataType: 'json',
		                data: {id: id},
		                type:"GET",
		                success: function(res){
		                    if(res.status == 'success'){
		                    	click.closest('tr').remove();
		                    	$('.successMsg-show').html('Organization details deleted successfully.').show();
		                    	getTable();
		                    }else if(res.status == 'error'){
		                    	$('.errorMsg-show').html(res.msg).show();
		                    }
		                },error: function(e){
		                    $('.errorMsg-show').html(e.responseText).show();
		                }
		            });
				}
				return false;
			});

			$(document).on('click', '.restoreOrganization', function (){
				var click = $(this);
				var id = click.attr('data-id');
				$('.errorMsg-show').html('').hide();
				$('.successMsg-show').html('').hide();
				var con = confirm('Are you sure to restore this organization?');
				if(con){
					$.ajax({
		                url:"{{ url('organization/restore') }}",
		                dataType: 'json',
		                data: {id: id},
		                type:"GET",
		                success: function(res){
		                    if(res.status == 'success'){
		                    	$('.successMsg-show').html('Organization has been restored successfully.').show();
		                    	getTable();
		                    }else if(res.status == 'error'){
		                    	$('.errorMsg-show').html(res.msg).show();
		                    }
		                },error: function(e){
		                    $('.errorMsg-show').html(e.responseText).show();
		                }
		            });
				}
				return false;
			});

			function getTable(){
				var search = $('#search_filter').val();
				$('.errorMsg-show').html('').hide();
				$.ajax({
	                url:"{{ url('organization/view') }}",
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