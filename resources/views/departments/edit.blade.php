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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Edit Department</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{url('departments')}}" id="kt_help_toggle" class="btn btn-sm btn-primary" >Manage Departments</a>
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

						<form action="{{url('/departments/'.$record->id)}}" method="POST">
							@method('patch')
							@csrf
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Name</label>
										<input type="text" name="name" class="form-control mb-2" placeholder="name" value="{{old('name', $record->name)}}">
										@if($errors->has("name"))
											<span id="name-error" class="help-block">{!! $errors->first("name") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Code</label>
										<input type="text" name="code" class="form-control mb-2" placeholder="code" value="{{old('code', $record->code)}}">
										@if($errors->has("code"))
											<span id="code-error" class="help-block">{!! $errors->first("code") !!}</span>
										@endif
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
								<button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Update Changes</button>
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