<?php 
	use App\Models\Categorygallery;
?>
@extends("master")

@section('maincontent')

	<style type="text/css">
		.separatePageBox {
			display: none;
		}
	</style>
	<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<!--begin::Toolbar-->
		<div class="toolbar" id="kt_toolbar">
			<!--begin::Container-->
			<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
				<!--begin::Page title-->
				<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
					<!--begin::Title-->
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Update Category</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{url('/master/category')}}" id="kt_help_toggle" class="btn btn-sm btn-primary" >Manage Category</a>
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
						<form action="{{url('/master/category/update')}}" method="POST">
							@csrf
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Name</label>
										<input type="text" name="categoryName" class="form-control mb-2" placeholder="Category Name" value="{{$category->cat_name}}">
										@if($errors->has("categoryName"))
											<span id="name-error" class="help-block">{!! $errors->first("categoryName") !!}</span>
										@endif
									</div>
								</div>
								<input type="hidden" name="edit_id" id="edit_id" value="{{$category->id}}">
								
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Status</label>
										<select id="status" data-control="select2" name="status" class="form-control form-select-solid form-select-lg fw-bold">
										<option value="active" <?php if($category->status == 'active'){ echo 'selected'; } ?>>Active</option>
										<option value="inactive" <?php if($category->status == 'inactive'){ echo 'selected'; } ?>>Inactive</option>
										</select>
										@if($errors->has("status"))
											<span id="status-error" class="help-block">{!! $errors->first("status") !!}</span>
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

	$('#separatePage').on('change', function(){
		separatepagefunc();
	});

	separatepagefunc();
	function separatepagefunc(){
		v = $('#separatePage').val();
		$('.separatePageBox').hide();
		if(v == 'yes'){
			$('.separatePageBox').show();
		}
	}
</script>


@endsection