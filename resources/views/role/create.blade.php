@extends('master')
@section('maincontent')
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<!--begin::Toolbar-->
		<div class="toolbar" id="kt_toolbar">
			<!--begin::Container-->
			<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
				<div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
					<h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Add User Role</h1>
				</div>
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{url('/role')}}" class="btn btn-sm btn-primary">Manage Roles</a>
				</div>
			</div>
			<!--end::Container-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Post-->
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<!--begin::Container-->
			<div id="kt_content_container" class="container-fluid">
				<form id="roleForm" class="form" >
					@csrf
					<div class="row">
						<div class="col-md-12">
							<div class="card card-flush">
								<!--begin::Card body-->
								<div class="card-body">
									<!--begin:Form-->
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label>Role Name <span class="text-danger">*</span></label>
													<input type="text" class="form-control form-control-solid" placeholder="enter role name" name="name" id="name" />
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<table class="table table-row-dashed">
														<thead>
															<tr>
																<th>
																	<div class="form-check form-check-sm form-check-custom form-check-solid">
																		<input class="form-check-input" type="checkbox" name="selectAll" id="selectAll"/>
																	</div>
																</th>
																<th>Permission</th>
															</tr>
														</thead>
														<tbody>
															@foreach($permissions as $per)
																<tr>
																	<td>
																		<div class="form-check form-check-sm form-check-custom form-check-solid">
																			<input class="form-check-input perMissions" type="checkbox" name="permission[]" id="permission" value="{{$per->id}}" >
																	</div>

																	</td>
																	<td>{{ $per->name }}</td>
																</tr>
															@endforeach
														</tbody>
													</table>
												
												</div>
											</div>
											
										</div>

										<!--begin::Actions-->
										<div class="text-end mt-5">
											<button type="reset" id="kt_modal_new_target_cancel" class="btn btn-light me-3">Cancel</button>
											<button id="kt_modal_new_target_submit" class="btn btn-primary submitBtn">
												<span class="indicator-label submitForm">Submit</span>
												<span class="indicator-progress">Please wait...
												<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
											</button>
										</div>
										<div class="alert alert-success showSuccess" style="display:none;"></div>
										<div class="alert alert-danger errorMsg-show" style="display:none;" ></div>
										<!--end::Actions-->
									<!--end:Form-->
								</div>
								<!--end::Card body-->
							</div>
						</div>
					</div>
				</form>
			</div>
			<!--end::Container-->
		</div>
		<!--end::Post-->
	</div>
@endsection
@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '#selectAll', function(){
				if(this.checked){
					$('.perMissions').prop('checked', true);
				}else{
					$('.perMissions').prop('checked', false);
				}
			});

			$('.perMissions').click(function(){
				var total_count = parseInt($('.perMissions').length);
				var total_checkd = parseInt($('.perMissions:checked').length);
				if(total_count == total_checkd){
					$('#selectAll').prop('checked', true);
				}else{
					$('#selectAll').prop('checked', false);
				}
			});
			

			$(document).on('click', '.submitBtn', function(){
				$('.validation-errors').remove();
				var data = $('#roleForm').serialize();
				$('.indicator-progress').show();
				$('.submitForm').hide();
				var btn = $(this);
				btn.attr('disabled', true);
				$.ajax({
	                url:"{{url('/role')}}",
	                data: data,
	                headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),}, 
	                type:"POST",
	                success: function(res){
	                    if(res.status == 'success'){
	                    	$('.showSuccess').html(res.msg).show();
	                    	$('.indicator-progress').hide();
							$('.submitForm').show();
							$('.errorMsg-show').hide();
							btn.attr('disabled', false);
	                    }else if(res.status == 'validation'){
                    		var valid = res.msg;
	                        $.each(valid, function(e,v){
	                        	if(e == "permission"){
	                        		 $('.errorMsg-show').html(v[0]).show();
	                        	}
	                            else {
	                            	$('#'+e).after('<span class="help-block validation-errors">'+v[0]+'</span>');
	                            }
	                        });
	                        $('.showSuccess').hide();
	                        $('.indicator-progress').hide();
							$('.submitForm').show();
							btn.attr('disabled', false);
                    	}else if(res.status == 'error'){
	                    	$('.errorMsg-show').html(res.msg).show();
	                    	$('.indicator-progress').hide();
							$('.submitForm').show();
							btn.attr('disabled', false);
							$('.showSuccess').hide();
	                    }
	                },error: function(e){
	                    $('.errorMsg-show').html(e.responseText).show();
	                    $('.indicator-progress').hide();
						$('.submitForm').show();
						btn.attr('disabled', false);
						$('.showSuccess').hide();
	                }
	            });
	            return false;
			});
		});

	</script>
@endsection