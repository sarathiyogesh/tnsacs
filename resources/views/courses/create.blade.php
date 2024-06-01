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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Add Courseee</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				@if(Gate::check('course-view') || Gate::check('course-edit'))
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{url('courses/manage')}}" id="kt_help_toggle" class="btn btn-sm btn-primary" >Manage Courses</a>
				</div>
				@endif
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
						<form action="{{url('/courses/create')}}" class="selectiveForm" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Course Name</label>
										<input type="text" name="courseName" id="courseName" class="form-control mb-2" placeholder="Course Name" value="{{old('courseName')}}">
										@if($errors->has("courseName"))
											<span id="name-error" class="help-block">{!! $errors->first("courseName") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Course Description</label>
										<textarea name="description" id="description" class="form-control mb-2 summernote" placeholder="Course Description" rows="3">{{old('description')}}</textarea>
										@if($errors->has("description"))
											<span id="name-error" class="help-block">{!! $errors->first("description") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Course Image</label>
										<input type="file" name="courseImage" id="courseImage" class="form-control"  >
										@if($errors->has("courseImage"))
											<span id="name-error" class="help-block">{!! $errors->first("courseImage") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group selectDiv">
										<label class="required form-label">Course Category</label>
										<select name="category" id="category" class="form-control form-select-solid form-select-lg fw-bold" data-control="select2">
											<option value="">Select</option>
											@foreach($category as $cat)
												<option value="{{$cat->id}}" <?php if(old('category') == $cat->id){ echo 'selected'; } ?>>{{$cat->cat_name}}</option>
											@endforeach
										</select>
										@if($errors->has("category"))
											<span id="name-error" class="help-block">{!! $errors->first("category") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group selectDiv">
										<label class="required form-label">Course Subject</label>
										<select name="subject" id="Subject" class="form-control form-select-solid form-select-lg fw-bold" data-control="select2">
											<option value="">Select</option>
											@foreach($subject as $sub)
												<option value="{{$sub->id}}" <?php if(old('subject') == $sub->id){ echo 'selected'; } ?>>{{$sub->name}}</option>
											@endforeach
										</select>
										@if($errors->has("subject"))
											<span id="name-error" class="help-block">{!! $errors->first("subject") !!}</span>
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
@section('styles')
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

		//Summernote
		$('.summernote').summernote({
		    callbacks: {
		        onImageUpload: function(image) {
		            uploadImage(image[0]);
		        }
		    }
		});

		$('#dob').datepicker({
			format: 'dd-mm-yyyy'
		});
	});
</script>


@endsection