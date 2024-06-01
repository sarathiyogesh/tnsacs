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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Add User</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{url('users')}}" id="kt_help_toggle" class="btn btn-sm btn-primary" >Manage Users</a>
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

						<form action="{{url('/employees')}}" method="POST">
							@csrf
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Name</label>
										<input type="text" name="name" class="form-control mb-2" placeholder="name" value="{{old('name')}}">
										@if($errors->has("name"))
											<span id="name-error" class="help-block">{!! $errors->first("name") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Designation</label>
										<input type="text" name="designation" class="form-control mb-2" placeholder="Designation" value="{{old('designation')}}">
										@if($errors->has("designation"))
											<span id="designation-error" class="help-block">{!! $errors->first("designation") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Gender</label>
										<br>
										<input type="radio" name="gender" value="Male" @if(!old() || old('gender') == 'Male') checked="checked" @endif>  Male &nbsp;
										<input type="radio" name="gender" value="Female" @if(old('gender') == 'Female') checked="checked" @endif>  Female 
										@if($errors->has("gender"))
											<span id="gender-error" class="help-block">{!! $errors->first("gender") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Mobile</label>
										<input type="text" name="mobile" class="form-control mb-2" placeholder="Mobile" value="{{old('mobile')}}">
										@if($errors->has("mobile"))
											<span id="mobile-error" class="help-block">{!! $errors->first("mobile") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class=" form-label">Alernative Mobile</label>
										<input type="text" name="mobile2" class="form-control mb-2" placeholder="Alernative Mobile" value="{{old('mobile2')}}">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Email</label>
										<input type="text" name="email" class="form-control mb-2" placeholder="Email Address" value="{{old('email')}}">
										@if($errors->has("email"))
											<span id="email-error" class="help-block">{!! $errors->first("email") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Department</label>
										<select name="dept" aria-label="Select Department" data-control="select2" data-placeholder="Select Department" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="">Select Department</option>
											@foreach($departments as $dept)
												<option  value="{{$dept->id}}" @if(old('dept') == $dept->id) selected="selected" @endif>{{$dept->name}}</option>
											@endforeach
										</select>
										@if($errors->has("dept"))
											<span id="dept-error" class="help-block">{!! $errors->first("dept") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Date of Birth</label>
										<input type="text" name="dob" id="dob" class="form-control mb-2" placeholder="Date of Birth" value="{{old('dob')}}" autocomplete="off">
										@if($errors->has("dob"))
											<span id="dob-error" class="help-block">{!! $errors->first("dob") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Role</label>
										<select name="role" aria-label="Select Role" data-control="select2" data-placeholder="Select Role" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="">Select Role</option>
											@foreach($roles as $role)
												<option value="{{$role->id}}" @if(old('role') == $role->id) selected="selected" @endif>{{$role->name}}</option>
											@endforeach
										</select>
										@if($errors->has("role"))
											<span id="role-error" class="help-block">{!! $errors->first("role") !!}</span>
										@endif
									</div>
								</div>
							</div>
							<div class="d-flex justify-content-end py-6">
								<button type="reset" class="btn btn-light btn-active-light-primary me-2">Reset</button>
								<button type="button" class="btn btn-primary" id="kt_account_profile_details_submit">Save </button>
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