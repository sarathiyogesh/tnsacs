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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Edit Post</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{url('blogs/post/view')}}" id="kt_help_toggle" class="btn btn-sm btn-primary" >Manage Posts</a>
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

						<form id="addPostForm">
							@csrf
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Title</label>
										<input type="text" name="post_title" class="form-control mb-2" placeholder="Post Title" id="post_title" value="{{$record->post_title}}">
										@if($errors->has("post_title"))
											<span id="post_title-error" class="help-block">{!! $errors->first("post_title") !!}</span>
										@endif
									</div>
								</div>


								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Slug</label>
										<div class="clearfix"></div>
									  	<div class="dib pull-left slug-input-holder">
											<input type="text" name="post_title_slug" class="form-control mb-2" placeholder="Post Title Slug"  id="post_title_slug" value="{{$record->post_title_slug}}">
											@if($errors->has("post_title_slug"))
												<span id="post_title_slug-error" class="help-block">{!! $errors->first("post_title_slug") !!}</span>
											@endif
										</div>
										<div class="fs-8 text-black">http://bookingbash.com/blogs/</div>
									</div>
								</div>
								
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Category</label>
										<select name="categories[]" aria-label="Select category" data-control="select2" data-placeholder="Select category" class="form-select form-select-solid form-select-lg fw-bold" id="categories" multiple>
											@foreach($categories as $cat)
												<option value="{{$cat->category_id}}" @if(in_array($cat->category_id, $selected_categories)) selected="selected" @endif>{{$cat->name}}</option>
											@endforeach
											
										</select>
										@if($errors->has("category"))
											<span id="category-error" class="help-block">{!! $errors->first("category") !!}</span>
										@endif
									</div>
								</div>
								<!-- <div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Sub category</label>
										<select name="sub_categories[]" aria-label="Select Sub category" data-control="select2" data-placeholder="Select Sub category" class="form-select form-select-solid form-select-lg fw-bold" id="sub_categories" multiple>
											
										</select>
										@if($errors->has("sub_categories"))
											<span id="sub_categories-error" class="help-block">{!! $errors->first("sub_categories") !!}</span>
										@endif
									</div>
								</div> -->

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Tags</label>
										<select name="tags[]" aria-label="Select Tags" data-control="select2" data-placeholder="Select Tags" class="form-select form-select-solid form-select-lg fw-bold" multiple id="tags">
											@foreach($tags as $tag)
												<option value="{{$tag->tag_id}}" @if(in_array($tag->tag_id, $chosenTags)) selected="selected" @endif>{{$tag->text}}</option>
											@endforeach
										</select>
										@if($errors->has("tags"))
											<span id="tags-error" class="help-block">{!! $errors->first("tags") !!}</span>
										@endif
									</div>
								</div>
								
								<div class="col-md-6 mb-15">
									<div class="form-group">
										<label for="featuredImage">Featured image</label>
									  	
									  	<div class="row">
									  		<div class="col-sm-12">
											  	<input style="display: inline-block" type="file" id="featuredImage" onchange="loadImg()" name="post_featured_string" id="post_featured_string" /> 
												<button class="btn-danger btn-small cancelUpload" style="display:none;">Cancel upload</button>
											</div>
										</div>
										@if(isset($record->featured_image))
											<img class="featured-image" src="{{$record->featured_image}}">
										@endif
										<div class="fs-8 text-black">Dimension atleast 850px x 315px</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Status</label>
										<select name="status" aria-label="Select Status" data-control="select2" data-placeholder="Select Status" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="">Select Status</option>
											<option value="active" @if($record->status == 'active') selected="selected" @endif>Active</option>
											<option value="inactive" @if($record->status == 'inactive') selected="selected" @endif>Inactive</option>
										</select>
										@if($errors->has("status"))
											<span id="status-error" class="help-block">{!! $errors->first("status") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Post Description</label>
										<textarea name="description" id="post_description" class="form-control mb-2" rows="3">{!! $record->post_description !!}</textarea>
										@if($errors->has("post_description"))
											<span id="post_description-error" class="help-block">{!! $errors->first("post_description") !!}</span>
										@endif
									</div>
								</div>

							</div>

							<div class="d-flex justify-content-end py-6">
								<button type="reset" class="btn btn-light btn-active-light-primary me-2">Reset</button>
								<button type="submit" class="btn btn-primary saveBtn" id="kt_account_profile_details_submit">Save </button>
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
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#dob').datepicker({
			format: 'dd-mm-yyyy'
		});
		CKEDITOR.replace('post_description');
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
		$('#featuredImage').val('');
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
		$('.validationError').remove();
		var btn = $(this);
		btn.prop('disabled', true);
		 var form = $('#addPostForm')[0];
		 var post_id = "{{$record->post_id}}";
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
		var des = CKEDITOR.instances.post_description.getData();
		var fd = new FormData(form);
            // fd.append('status',type);
            fd.append('post_description', des);
            fd.append('categories', categories);
            fd.append('tags', tags);
            fd.append('post_id', post_id);
		$.ajax({
           url:"{{ url('blogs/post/update') }}",
           data: fd,
           type:"POST",
           headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),},
           cache : false,
            contentType: false,
            processData : false,
           success: function(res){
                if(res.status == 'success'){
                	$('.successMsg-show').html(res.msg).show();
                	btn.prop('disabled', false);
                }else if(res.status == 'error'){
                	$('.errorMsg-show').html(res.msg).show();
                	btn.prop('disabled', false);
                }else if(res.status == 'validation'){
                	btn.prop('disabled', false);
                	var valid = res.msg;
                    $.each(valid, function(k,v){
                    	if(k == 'post_featured_string'){
                    		alert('Image Field : '+v);
                    	}
		        		$('#'+k).after('<span class="text-danger validationError" >'+v[0]+'</span>');
		        	});
		        	
                }
            },error: function(e){
                $('.errorMsg-show').html(e.responseText).show();
                btn.prop('disabled', false);
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