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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">New Blog</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{url('blogs/post/view')}}" id="kt_help_toggle" class="btn btn-sm btn-primary" >Manage Blogs</a>
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

						<div class="alert alert-success successMsg-show" style="display:none;"></div>
						<div class="alert alert-danger errorMsg-show" style="display:none;"></div>

						<form id="addPostForm" action="{{ url('blogs/post/save') }}" method="POST">
							@csrf
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Title</label>
										<input type="text" name="title" class="form-control mb-2" placeholder="Post Title" id="title" value="{{ old('title') }}">
										@if($errors->has("title"))
											<span id="title-error" class="help-block">{!! $errors->first("title") !!}</span>
										@endif
									</div>
								</div>


								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Date</label>
										<div class="clearfix"></div>
									  	<div class="dib pull-left date-input-holder">
											<input type="text" name="date" class="form-control mb-2" placeholder="Post Date"  id="date" autocomplete="off" value="{{ old('date')}}">
											@if($errors->has("date"))
												<span id="date-error" class="help-block">{!! $errors->first("date") !!}</span>
											@endif
										</div>
									</div>
								</div>


								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Short Description</label>
										<textarea name="short_description" id="short_description" class="form-control mb-2" rows="3">{!! old('short_description') !!}</textarea>
										@if($errors->has("short_description"))
											<span id="short_description-error" class="help-block">{!! $errors->first("short_description") !!}</span>
										@endif
									</div>
								</div>


								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Post Description</label>
										<textarea name="description" id="description" class="form-control mb-2" rows="3">{!! old('description') !!}</textarea>
										@if($errors->has("description"))
											<span id="description-error" class="help-block">{!! $errors->first("description") !!}</span>
										@endif
									</div>
								</div>
								
								<div class="col-md-6 mb-15">
									<div class="form-group">
										<label for="featuredImage">Featured image</label>
									  	<div class="row">
									  		<div class="col-sm-12">
											  	@include('media.select_media_template',['options'=>['select'=>'yes','select_type'=>'single','input_name'=>'feature_image','values'=>old('feature_image'), 'id' => 'feature_image']])
											</div>
										</div>
										<img class="featured-image" src="">
										@if($errors->has("feature_image"))
											<span id="feature_image-error" class="help-block">{!! $errors->first("feature_image") !!}</span>
										@endif
										<div class="fs-8 text-black">Dimension atleast 850px x 315px</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Status</label>
										<select name="status" aria-label="Select Status" data-control="select2" data-placeholder="Select Status" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="">Select Status</option>
											<option value="active" @if(old('status', 'active') == 'active') selected @endif>Active</option>
											<option value="inactive" @if(old('status') == 'inactive') selected @endif>Inactive</option>
										</select>
										@if($errors->has("status"))
											<span id="status-error" class="help-block">{!! $errors->first("status") !!}</span>
										@endif
									</div>
								</div>

								

							</div>

							<div class="d-flex justify-content-end py-6">
								<button type="reset" class="btn btn-light btn-active-light-primary me-2">Reset</button>
								<button type="submit" class="btn btn-primary">Save </button>
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

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('backend/js/media_handler.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#date').datepicker({
			format: 'dd-mm-yyyy'
		});
		CKEDITOR.replace('description');
		CKEDITOR.replace('short_description');
	});

	function loadImg(){
		$('.featured-image').attr('src', URL.createObjectURL(event.target.files[0]));
		$('.cancelUpload').show();
	}

	$(document).on('click', '.cancelUpload', function(){
		cancelPreview();
	});

	function cancelPreview(){
		$('.featured-image').removeProp('src').hide();
		$('#post_featured_string').val('');
		$('.cancelUpload').hide();
		return false;
	}

	$(document).on('keyup', '#post_title', function(){
		var title = $('#post_title').val();
		if(title){
			$('#post_title_slug').prop("readonly", true);
			$.ajax({
	            url:"{{ url('blogs/getpostslug') }}",
	            data: { title:title},
	            type:"GET",
	            success: function(res){
	                if(res.status == 'success'){
	                	$('#post_title_slug').val(res.slug);
	                	$('#post_title_slug').prop("readonly", false);
	                }
	            },error: function(e){
	                $('.errorMsg-show').html(e.responseText).show();
	            }
	        });
	        return false;
	    }
	});

	$(document).on('click', '.saveBtn', function(){
		 var form = $('#addPostForm')[0];
		// var type = "draft";
		var categories = [];
	    $('#categories').each(function(){
	        var data = $(this).val();
	        categories.push(data);
	    });
	    var tags = [];
	    $('#tags').each(function(){
	        var ta = $(this).val();
	        tags.push(ta);
	    });
		var des = CKEDITOR.instances.description.getData();
		var fd = new FormData(form);
            // fd.append('status',type);
            fd.append('post_description', des);
            fd.append('categories', categories);
            fd.append('tags', tags);
		$.ajax({
           url:"{{ url('blogs/post/save') }}",
           data: fd,
           type:"POST",
           headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),},
           cache : false,
            contentType: false,
            processData : false,
           success: function(res){
                if(res.status == 'success'){
                	$('.successMsg-show').html(res.msg).show();
                	$('#addPostForm')[0].reset();
                	$('#categories').val("").change();
                	$('#tags').val("").change();
                	CKEDITOR.instances.post_description.setData('');
                	cancelPreview();

                }else if(res.status == 'error'){
                	$('.errorMsg-show').html(res.msg).show();
                }else if(res.status == 'validation'){
                	var valid = res.msg;
                    $.each(valid, function(k,v){
		        		$('#'+k).after('<span class="text-danger validationError" >'+v[0]+'</span>');
		        	});
                }
            },error: function(e){
                $('.errorMsg-show').html(e.responseText).show();
            }
       });
		return false;
	});

	// $(document).on('change', '#categories', function(){
	// 	var category_id = $('#categories').val();
	// 	$.ajax({
 //            url:"{{ url('blogs/posts/getsubcategories') }}",
 //            data: { category_id:category_id},
 //            type:"GET",
 //            success: function(res){
 //                if(res.status == 'success'){
 //                	$('#sub_categories').html(res.subs);
 //                }else if(res.status == 'error'){
 //                	$('.errorMsg-show').html(res.msg).show();
 //                }
 //            },error: function(e){
 //                $('.errorMsg-show').html(e.responseText).show();
 //            }
 //        });
	// 	return false;
		
	// });
</script>


@endsection