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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Add Staff</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{url('partner/manage')}}" id="kt_help_toggle" class="btn btn-sm btn-primary" >Manage Staff</a>
				</div>
				<!--end::Actions-->
			</div>
			<!--end::Container-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Post-->
		{!! Helpers::displaymsg() !!}
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<div id="kt_content_container" class="container-xxl">
				<div class="card card-flush">
					<div class="card-body">

						<form action="" method="POST">
							@csrf
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Name</label>
										<input type="text" name="StaffName" class="form-control mb-2" placeholder="Staff Name" value="{{old('StaffName')}}">
										@if($errors->has("StaffName"))
											<span id="name-error" class="help-block">{!! $errors->first("StaffName") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Email</label>
										<input type="text" name="offerName" class="form-control mb-2" placeholder="Staff Email" value="{{old('offerName')}}">
										@if($errors->has("offerName"))
											<span id="offerName-error" class="help-block">{!! $errors->first("offerName") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Phone</label>
										<input type="text" name="offerName" class="form-control mb-2" placeholder="Staff Contact Number" value="{{old('offerName')}}">
										@if($errors->has("offerName"))
											<span id="offerName-error" class="help-block">{!! $errors->first("offerName") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Staff Image</label>
										<input type="file" name="logo" class="form-control mb-2" placeholder="Staff Image" value="{{old('logo')}}">
										@if($errors->has("logo"))
											<span id="logo-error" class="help-block">{!! $errors->first("logo") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Type</label>
										<select name="offerType" aria-label="Select Department" data-control="select2" data-placeholder="Select Department" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="bank" <?php if(old('offerType') == 'bank'){ echo 'selected'; } ?>>Management</option>
											<option value="couponcode" <?php if(old('offerType') == 'couponcode'){ echo 'selected'; } ?>>Sales/Finance</option>
										</select>
										@if($errors->has("offerType"))
											<span id="offerType-error" class="help-block">{!! $errors->first("offerType") !!}</span>
										@endif
									</div>
								</div>


								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Status</label>
										<select id="status" data-control="select2" name="status" class="form-control form-select-solid form-select-lg fw-bold">
										<option value="1" <?php if(old('status') == '1'){ echo 'selected'; } ?>>Active</option>
										<option value="0" <?php if(old('status') == '0'){ echo 'selected'; } ?>>Inactive</option>
										</select>
										@if($errors->has("status"))
											<span id="status-error" class="help-block">{!! $errors->first("status") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Message</label>
										<input type="text" name="offerMessage" class="form-control mb-2" placeholder="Notes (Instructions)" value="{{old('offerMessage')}}">
										@if($errors->has("offerMessage"))
											<span id="offerMessage-error" class="help-block">{!! $errors->first("offerMessage") !!}</span>
										@endif
									</div>
								</div>


							</div>
							<div class="d-flex justify-content-end py-6">
								<button type="reset" class="btn btn-light btn-active-light-primary me-2">Reset</button>
								<button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save </button>
							</div>
						</form>
					</div>
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
		$('#dob').datepicker({
			format: 'dd-mm-yyyy'
		});
	});
</script>


@endsection