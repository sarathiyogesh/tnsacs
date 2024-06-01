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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">New Event</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{url('event')}}" id="kt_help_toggle" class="btn btn-sm btn-primary" >Manage Events</a>
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

						<form id="addEventForm">
							@csrf
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Event Name</label>
										<input type="text" name="name" class="form-control mb-2" placeholder="Event Name" id="name">
										@if($errors->has("name"))
											<span id="name-error" class="help-block">{!! $errors->first("name") !!}</span>
										@endif
									</div>
								</div>

								
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Category</label>
										<select name="category" aria-label="Select category" data-control="select2" data-placeholder="Select category" class="form-select form-select-solid form-select-lg fw-bold" id="category">
											<option value="">Select</option>
											@foreach($categories as $cat)
												<option value="{{$cat->id}}">{{$cat->name}}</option>
											@endforeach
											
										</select>
										@if($errors->has("category"))
											<span id="category-error" class="help-block">{!! $errors->first("category") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Country</label>
										<select name="country" aria-label="Select country" data-control="select2" data-placeholder="Select country" class="form-select form-select-solid form-select-lg fw-bold" id="country">
											<option value="">Select</option>
											@foreach($countries as $country)
												<option value="{{$country->id}}">{{$country->country_name}}</option>
											@endforeach
											
										</select>
										@if($errors->has("country"))
											<span id="country-error" class="help-block">{!! $errors->first("country") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label">City</label>
										<select name="city" aria-label="Select city" data-control="select2" data-placeholder="Select city" class="form-select form-select-solid form-select-lg fw-bold" id="city">
											<option value="">Select</option>
											@foreach($cities as $city)
												<option value="{{$city->id}}">{{$city->name}}</option>
											@endforeach
											
										</select>
										@if($errors->has("city"))
											<span id="city-error" class="help-block">{!! $errors->first("city") !!}</span>
										@endif
									</div>
								</div>
								

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Languages</label>
										<select name="language" aria-label="Select language" data-control="select2" data-placeholder="Select language" class="form-select form-select-solid form-select-lg fw-bold"  id="language">
											<option value="">Select</option>
											@foreach($languages as $lan)
												<option value="{{$lan->id}}">{{$lan->name}}</option>
											@endforeach
										</select>
										@if($errors->has("language"))
											<span id="language-error" class="help-block">{!! $errors->first("language") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Event Location</label>
										<input type="text" name="location" class="form-control mb-2" placeholder="Event Location" id="location">
										@if($errors->has("location"))
											<span id="location-error" class="help-block">{!! $errors->first("location") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Address</label>
										<input type="text" name="address" class="form-control mb-2" placeholder="Address" id="address">
										@if($errors->has("address"))
											<span id="address-error" class="help-block">{!! $errors->first("address") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Status</label>
										<select name="status" aria-label="Select Status" data-control="select2" data-placeholder="Select Status" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="">Select Status</option>
											<option value="active" selected>Active</option>
											<option value="inactive" >Inactive</option>
										</select>
										@if($errors->has("status"))
											<span id="status-error" class="help-block">{!! $errors->first("status") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Start Date</label>
										<input type="text" name="start_date" class="form-control mb-2" placeholder="Start Date" id="start_date" autocomplete="off">
										@if($errors->has("start_date"))
											<span id="start_date-error" class="help-block">{!! $errors->first("start_date") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">End Date</label>
										<input type="text" name="end_date" class="form-control mb-2" placeholder="End Date" id="end_date" autocomplete="off">
										@if($errors->has("end_date"))
											<span id="end_date-error" class="help-block">{!! $errors->first("end_date") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Price</label>
										<input type="text" name="price" class="form-control mb-2" placeholder="Price" id="price">
										@if($errors->has("price"))
											<span id="price-error" class="help-block">{!! $errors->first("price") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">API ID</label>
										<input type="text" name="api_code" class="form-control mb-2" placeholder="API CODE" id="api_code">
										@if($errors->has("api_code"))
											<span id="price-error" class="help-block">{!! $errors->first("api_code") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Description</label>
										<textarea name="description" id="description" class="form-control mb-2" rows="3"></textarea>
										@if($errors->has("description"))
											<span id="description-error" class="help-block">{!! $errors->first("description") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6 featureImgDiv">
									<div class="form-group">
										<label for="featuredImage">Featured image</label>
									  	{{-- <span class="help-block">Dimension atleast 850px x 315px</span> --}}
									  	
									  	<div class="row mb-15">
									  		<div class="col-sm-12">
											  	<input style="display: inline-block" type="file" onchange="loadImg('feature')" name="feature_image" id="feature_image" /> 
												<button class="btn-danger btn-small cancelUpload"  data-id="featuredimage" style="display:none;">Cancel upload</button>
											</div>
										</div>
										<img class="featuredimage featured-image" src="">

									</div>
								</div>

								<div class="col-md-6 bannerImgDiv">
									<div class="form-group">
										<label for="featuredImage">Banner image</label>
									  	{{-- <span class="help-block">Dimension atleast 850px x 315px</span> --}}
									  	
									  	<div class="row mb-15">
									  		<div class="col-sm-12">
											  	<input style="display: inline-block" type="file" onchange="loadImg('banner')" name="banner_image" id="banner_image" /> 
												<button class="btn-danger btn-small cancelUpload" data-id="bannerimage" style="display:none;">Cancel upload</button>
											</div>
										</div>
										<img class="bannerimage featured-image" src="">

									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Price Range</label>
										<input type="text" name="price" class="form-control mb-2" placeholder="Price Range" id="price">
										@if($errors->has("price"))
											<span id="price-error" class="help-block">{!! $errors->first("price") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Header Tag</label>
										<input type="text" name="header_tag" class="form-control mb-2" placeholder="Header Tag" id="header_tag">
										@if($errors->has("header_tag"))
											<span id="header_tag-error" class="help-block">{!! $errors->first("header_tag") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Meta Title</label>
										<input type="text" name="meta_title" class="form-control mb-2" placeholder="Meta Title" id="meta_title">
										@if($errors->has("meta_title"))
											<span id="meta_title-error" class="help-block">{!! $errors->first("meta_title") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Meta Description</label>
										<input type="text" name="meta_description" class="form-control mb-2" placeholder="Meta Description" id="meta_description">
										@if($errors->has("meta_description"))
											<span id="meta_description-error" class="help-block">{!! $errors->first("meta_description") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Meta Keywords</label>
										<input type="text" name="meta_keywords" class="form-control mb-2" placeholder="Meta Keywords" id="meta_keywords">
										@if($errors->has("meta_keywords"))
											<span id="meta_keywords-error" class="help-block">{!! $errors->first("meta_keywords") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6 metaImgDiv">
									<div class="form-group">
										<label for="featuredImage">Meta Image</label>
									  	{{-- <span class="help-block">Dimension atleast 850px x 315px</span> --}}
									  	
									  	<div class="row mb-15">
									  		<div class="col-sm-12">
											  	<input style="display: inline-block" type="file" onchange="loadImg('meta')" name="meta_image" id="meta_image" /> 
												<button class="btn-danger btn-small cancelUpload" style="display:none;" data-id="metaimage" >Cancel upload</button>
											</div>
										</div>
										<img class=" featured-image metaimage" src="">

									</div>
								</div>



							</div>

							<div class="d-flex justify-content-end py-6">
								<button type="reset" class="btn btn-light btn-active-light-primary me-2">Reset</button>
								<button type="button" class="btn btn-primary saveBtn" id="kt_account_profile_details_submit">Save </button>
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
		$('#start_date').datepicker({
			format: 'dd-mm-yyyy'
		});
		$('#end_date').datepicker({
			format: 'dd-mm-yyyy'
		});
		CKEDITOR.replace('description');
	});

	function loadImg(type){
		if(type == 'feature'){
			var front = $('.featureImgDiv');
		}else if(type == 'banner'){
			var front = $('.bannerImgDiv');
		}else if(type == 'meta'){
			var front = $('.metaImgDiv');
		}
		front.find('.featured-image').attr('src', URL.createObjectURL(event.target.files[0]));
		front.find('.cancelUpload').show();
		return false;
	}

	$(document).on('click', '.cancelUpload', function(){
		var cl = $(this).attr('data-id');
		$('.'+cl).removeProp('src').hide();
		$(this).hide();
		$(this).closest("div").find("input[type=file]").val('');
		return false;
	});

	// function cancelPreview(){
	// 	$('.featured-image').removeProp('src').hide();
	// 	$('#feature_image').val('');
	// 	$('.cancelUpload').hide();
	// 	return false;
	// }


	$(document).on('click', '.saveBtn', function(){
		var th = $(this);
		$('.errorMsg-show').hide();
		$('.successMsg-show').hide();
		$('.validationError').remove();
		 var form = $('#addEventForm')[0];
		var des = CKEDITOR.instances.description.getData();
		var fd = new FormData(form);
            fd.append('description', des);
        th.text('Please wait...');
		$.ajax({
           url:"{{ url('event/save') }}",
           data: fd,
           type:"POST",
           headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),},
           cache : false,
            contentType: false,
            processData : false,
           success: function(res){
           		th.text('Save');
                if(res.status == 'success'){
                	$('.successMsg-show').html(res.msg).show();
                	$('#addEventForm')[0].reset();
                	$('#category').val("").change();
                	$('#country').val("").change();
                	$('#city').val("").change();
                	$('#language').val("").change();
                	CKEDITOR.instances.description.setData('');
                	$('.cancelUpload').hide();
                	$('.featured-image').removeProp('src').hide();

                }else if(res.status == 'error'){
                	$('.errorMsg-show').html(res.msg).show();
                }else if(res.status == 'validation'){
                	var valid = res.msg;
                    $.each(valid, function(k,v){
		        		$('#'+k).after('<span class="text-danger validationError" >'+v[0]+'</span>').focus();
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
 //            url:"{{ url('events/getsubcategories') }}",
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