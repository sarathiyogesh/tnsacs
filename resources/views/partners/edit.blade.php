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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Edit Partner</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{url('partner/manage')}}" id="kt_help_toggle" class="btn btn-sm btn-primary" >Manage Partner</a>
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

						<form action="{{url('/partner/editpost')}}" method="POST">
							@csrf
							<input type="hidden" name="editId" id="editId" value="{{$partner->id}}">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Name</label>
										<input type="text" name="partnerName" class="form-control mb-2" placeholder="Partner Name" value="{{ $partner->partner_name }}">
										@if($errors->has("partnerName"))
											<span id="name-error" class="help-block">{!! $errors->first("partnerName") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Offer Name</label>
										<input type="text" name="offerName" class="form-control mb-2" placeholder="Offer Name" value="{{$partner->offer_name}}">
										@if($errors->has("offerName"))
											<span id="offerName-error" class="help-block">{!! $errors->first("offerName") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Message</label>
										<input type="text" name="offerMessage" class="form-control mb-2" placeholder="Offer Name" value="{{$partner->offer_message}}">
										@if($errors->has("offerMessage"))
											<span id="offerMessage-error" class="help-block">{!! $errors->first("offerMessage") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Logo</label>
										<input type="file" name="logo" class="form-control mb-2" placeholder="Offer Name" value="{{old('logo')}}">

										<img src="{{asset($partner->partner_logo)}}" width="70px;" height="70px;">

										@if($errors->has("logo"))
											<span id="logo-error" class="help-block">{!! $errors->first("logo") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Type</label>
										<select name="offerType" aria-label="Select Department" data-control="select2" data-placeholder="Select Department" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="bank" <?php if($partner->offer_type == 'bank'){ echo 'selected'; } ?>>Bank</option>
											<option value="couponcode" <?php if($partner->offer_type == 'couponcode'){ echo 'selected'; } ?>>Coupon</option>
										</select>
										@if($errors->has("offerType"))
											<span id="offerType-error" class="help-block">{!! $errors->first("offerType") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Number first length</label>
										<?php $total = 10; ?>
										<select id="firstLength" data-control="select2" name="firstLength" class="form-control form-select-solid form-select-lg fw-bold">
											@for($i=1; $i<=10; $i++)
											<option value="{{$i}}" <?php if($partner->first_len == $i){ echo 'selected'; } ?>>{{$i}}</option>
											@endfor
										</select>
										@if($errors->has("firstLength"))
											<span id="firstLength-error" class="help-block">{!! $errors->first("firstLength") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Number last length</label>
										<?php $total = 10; ?>
										<select id="lastLength" data-control="select2" name="lastLength" class="form-control form-select-solid form-select-lg fw-bold">
											@for($i=1; $i<=10; $i++)
											<option value="{{$i}}" <?php if($partner->last_len == $i){ echo 'selected'; } ?>>{{$i}}</option>
											@endfor
										</select>
										@if($errors->has("lastLength"))
											<span id="lastLength-error" class="help-block">{!! $errors->first("lastLength") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">User can be used</label>
										<select id="usedType" data-control="select2" name="usedType" class="form-control form-select-solid form-select-lg fw-bold">
											<option value="single" <?php if($partner->used_type == 'single'){ echo 'selected'; } ?>>Single</option>
											<option value="multiple" <?php if($partner->used_type == 'multiple'){ echo 'selected'; } ?>>Multiple</option>
										</select>
										@if($errors->has("usedType"))
											<span id="usedType-error" class="help-block">{!! $errors->first("usedType") !!}</span>
										@endif
									</div>
								</div>

								<?php
									$planIds = [];
									$plans = DB::table('partner_offer_plan')->where('partner_offer_id', $partner->id)->get();
									foreach($plans as $pid){
										array_push($planIds,$pid->plan);
									}
								?>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Plan</label>
										<select id="plan" data-control="select2" name="plan[]" multiple class="form-control form-select-solid form-select-lg fw-bold">
											<option value="2" <?php if(in_array(2,$planIds)){ echo 'selected'; } ?>>6 Month</option>
											<option value="3" <?php if(in_array(3,$planIds)){ echo 'selected'; } ?>>12 Month</option>
										</select>
										@if($errors->has("plan"))
											<span id="plan-error" class="help-block">{!! $errors->first("plan") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Status</label>
										<select id="status" data-control="select2" name="status" class="form-control form-select-solid form-select-lg fw-bold">
										<option value="1" <?php if($partner->status == 1){ echo 'selected'; } ?>>Active</option>
										<option value="0" <?php if($partner->status == 0){ echo 'selected'; } ?>>Inactive</option>
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