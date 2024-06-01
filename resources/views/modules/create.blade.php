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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Add Module</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{url('admin/modules')}}" id="kt_help_toggle" class="btn btn-sm btn-primary" >Manage Modules</a>
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

						<form action="{{route('admin.module.save')}}" method="POST">
							@csrf
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Title</label>
										<input type="text" name="title" class="form-control mb-2" placeholder="title" value="{{old('title')}}">
										@if($errors->has("title"))
											<span id="name-error" class="help-block">{!! $errors->first("title") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Category</label>
										<input type="text" name="category" class="form-control mb-2" placeholder="category" value="{{old('category')}}">
										@if($errors->has("category"))
											<span id="name-error" class="help-block">{!! $errors->first("category") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label for="featuredImage">Banner image</label>
									  	<div class="row">
									  		<div class="col-sm-12">
											  	@include('media.select_media_template',['options'=>['select'=>'yes','select_type'=>'single','input_name'=>'banner_image','values'=>'']])
											  	@if($errors->has("banner_image"))
													<span id="name-error" class="help-block">{!! $errors->first("banner_image") !!}</span>
												@endif
											</div>
										</div>
										<img class="featured-image" src="">
										<div class="fs-8 text-black">Dimension atleast 850px x 315px</div>
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Description</label>
										<textarea class="form-control mb-2"  name="description">{{old('description')}}</textarea>
										@if($errors->has("description"))
											<span id="description-error" class="help-block">{!! $errors->first("description") !!}</span>
										@endif
									</div>
									<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Status</label>
										<select class="form-control mb-2"  name="status">
											<option value="">select</option>
											<option value="active" @if(old('status', 'active') == 'active') selected @endif>Active</option>
											<option value="inactive" @if(old('status') == 'inactive') selected @endif >Inactive</option>
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

@if(old('status', 'active') == 'active') selected @endif


		<!--end::Post-->
	</div>
	<!--end::Content-->
@endsection
@section('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('backend/js/media_handler.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#dob').datepicker({
			format: 'dd-mm-yyyy'
		});
	});
</script>


@endsection