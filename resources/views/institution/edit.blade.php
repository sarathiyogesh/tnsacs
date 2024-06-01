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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Edit Institution</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{url('institution/manage')}}" id="kt_help_toggle" class="btn btn-sm btn-primary" >Manage Institution</a>
				</div>
				<!--end::Actions-->
			</div>
			<!--end::Container-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Post-->
		
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<div id="kt_content_container" class="container-xxl">
				{!! Helpers::displaymsg() !!}
				<div class="card card-flush">
					<div class="card-body">

						<form action="/institution/editpost" class="selectiveForm" method="POST" enctype="multipart/form-data">
							@csrf
							<input type="hidden" name="editId" value="{{ $record->id }}">
							<div class="row">

								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Institution Logo</label>
										<input type="file" name="logo" class="form-control mb-2" placeholder="Logo" value="{{old('logo')}}">
										@if($errors->has("logo"))
											<span id="logo-error" class="help-block">{!! $errors->first("logo") !!}</span>
										@endif
									</div>
								</div>
								@if($record->logo)
									<div class="col-md-12 mb-4">
										<label class="required form-label">Uploaded Logo</label>
										<div class="uploaded-img">
											<img src="{{ asset($record->logo) }}" alt="institution logo">
										</div>
									</div>
								@endif

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Institution Name</label>
										<input type="text" name="name" class="form-control mb-2" placeholder="Name" value="{{old('name', $record->name)}}">
										@if($errors->has("name")) enctype="multipart/form-data"
											<span id="name-error" class="help-block">{!! $errors->first("name") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Institution Code</label>
										<input type="text" name="code" class="form-control mb-2" placeholder="Code" value="{{old('code', $record->code)}}">
										@if($errors->has("code"))
											<span id="name-error" class="help-block">{!! $errors->first("code") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Email</label>
										<input type="text" name="email" class="form-control mb-2" placeholder="Email" value="{{old('email', $record->email)}}">
										@if($errors->has("email"))
											<span id="email-error" class="help-block">{!! $errors->first("email") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Contact Number</label>
										<input type="text" name="mobile" class="form-control mb-2" placeholder="Contact Number" value="{{old('mobile', $record->mobile)}}">
										@if($errors->has("mobile"))
											<span id="mobile-error" class="help-block">{!! $errors->first("mobile") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Alternate Contact Number</label>
										<input type="text" name="mobile2" class="form-control mb-2" placeholder="Alternate Contact Number" value="{{old('mobile2', $record->mobile2)}}">
										@if($errors->has("mobile2"))
											<span id="mobile2-error" class="help-block">{!! $errors->first("mobile2") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Contact Person Name</label>
										<input type="text" name="contact_person_name" class="form-control mb-2" placeholder="Name" value="{{old('contact_person_name', $record->contact_person_name)}}">
										@if($errors->has("contact_person_name"))
											<span id="contact_person_name-error" class="help-block">{!! $errors->first("contact_person_name") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Contact Person Mobile</label>
										<input type="text" name="contact_person_mobile" class="form-control mb-2" placeholder="Mobile" value="{{old('contact_person_mobile', $record->contact_person_mobile)}}">
										@if($errors->has("contact_person_mobile"))
											<span id="contact_person_mobile-error" class="help-block">{!! $errors->first("contact_person_mobile") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Address</label>
										<input type="text" name="address" class="form-control mb-2" placeholder="Address" value="{{old('address', $record->address)}}">
										@if($errors->has("address"))
											<span id="address-error" class="help-block">{!! $errors->first("address") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group selectDiv">
										<label class="required form-label">State</label>
										<select class="form-control" name="state">
											<option value="">Select</option>
											@foreach($states as $state)
												<option value="{{ $state->id}}" <?php if(old('state', $record->state) == $state->id){ echo 'selected'; } ?>>{{ $state->state }}</option>
											@endforeach
											@if($errors->has("state"))
												<span id="state-error" class="help-block">{!! $errors->first("state") !!}</span>
											@endif
										</select>
									</div>
								</div>

								<div class="col-md-6">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="required form-label">City</label>
												<input type="text" name="city" class="form-control mb-2" placeholder="City" value="{{old('city', $record->city)}}">
												@if($errors->has("city"))
													<span id="city-error" class="help-block">{!! $errors->first("city") !!}</span>
												@endif
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label class="required form-label">Pincode</label>
												<input type="text" name="pincode" class="form-control mb-2" placeholder="Pincode" value="{{old('pincode', $record->pincode)}}">
												@if($errors->has("pincode"))
													<span id="pincode-error" class="help-block">{!! $errors->first("pincode") !!}</span>
												@endif
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group selectDiv">
										<label class="required form-label">Status</label>
										<select id="status" data-control="select2" name="status" class="form-control form-select-solid form-select-lg fw-bold">
										<option value="active" <?php if(old('status', $record->status) == 'active'){ echo 'selected'; } ?>>Active</option>
										<option value="inactive" <?php if(old('status', $record->status) == 'inactive'){ echo 'selected'; } ?>>Inactive</option>
										</select>
										@if($errors->has("status"))
											<span id="status-error" class="help-block">{!! $errors->first("status") !!}</span>
										@endif
									</div>
								</div>


							</div>
							<div class="d-flex justify-content-end py-6">
								<button type="reset" class="btn btn-light btn-active-light-primary me-2">Reset</button>
								<button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Update </button>
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