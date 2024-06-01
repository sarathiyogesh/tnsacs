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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Activity :: {{$activity->activity_name}}</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
					<div class="d-flex align-items-center gap-2 gap-lg-3">
						<a href="javascript:;" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addNewGalleryModel">Add Gallery</a>
					</div>
				<!--end::Actions-->
			</div>
			<!--end::Container-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Post-->
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<div id="kt_content_container" class="container-xxl">

				<div class="card card-flush mb-4">
					<div class="card-header py-5 gap-2 gap-md-5">
						<!--begin::Search-->
						<div class="row">
							@if(count($photos) > 0)
								@foreach($photos as $photo)
									<div class="col-md-12">
										<div class="d-flex align-items-center position-relative">
											<div class="w-100 sortable-container">
												<div sv-element="opts" class="w-100 well" style="overflow: auto">
													<div class="d-flex align-items-center  justify-content-between">
							            				<div><img src="{{$photo->thumbnail_url}}" class="gallery_thumbnail featured-image w-200px"></div>
							            				<div><a href="javascript:;" class="deleteBtn btn btn-primary btn-xs" data-id="{{$photo->photo_id}}" >Delete</a></div>
							            			</div>
							            			<!-- <div class="photo-info">
							            				<h4 class="pl10 m0">{{$photo->name}}</h4><br>
							            				<span class="pl10 m0">{{$photo->description}}</span>
							            			</div> -->
												</div>
											</div>
										</div>
									</div>
								@endforeach
							@else
								<div class="col-md-12">
									<div >
										No images in gallery
									</div>
								</div>
							@endif
						</div>
					</div>
				</div>

				<!-- Modal -->
				<div class="modal fade" id="addNewGalleryModel" tabindex="-1" aria-labelledby="addNewGalleryModelLabel" aria-hidden="true">
				  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLabel">Add Gallery</h5>
				        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				      </div>
				      <div class="modal-body">
				        <form id="photoForm">
						<!--begin::Body-->
						<div class="card-body" id="kt_help_body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Name of the photo</label>
										<input type="text" name="photo_name" id="photo_name" class="form-control" placeholder="Photo Name" value="">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Gallery image</label>
										<span class="help-block">Dimension atleast 850px x 350px</span>
										<input style="display: inline-block" type="file" id="newImage" name="newImage"/>
										<div class="col-md-6">
											<img class="featured-image" src="">
											<button type="button" class="btn-danger btn-small cancelBtn" style="display:none;">Cancel upload</button>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Description</label>
										<textarea name="photo_description" id="photo_description" style="width:100%" rows="4" placeholder="Description"></textarea>
									</div>
								</div>
								
							</div>
						</div>
						<!--end::Body-->
					</form>
				      </div>
				      <div class="modal-footer">
						<button type="button" class="btn btn-primary" id="savephoto">Save</button>
				      </div>
				    </div>
				  </div>
				</div>

			</div>
		</div>
		<!--end::Post-->

		<!--end::Help drawer-->
	</div>
	<!--end::Content-->
@endsection

@section('scripts')
	<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			CKEDITOR.replace('photo_description');

			$('#addNewGalleryModel').on('change', '#newImage', function() {
				$('.featured-image').attr('src', URL.createObjectURL(event.target.files[0]));
				$('.cancelBtn').show();
			});

			$(document).on('click', '.cancelBtn', function(){
				cancelPreview();
			});

			function cancelPreview(){
				$('.featured-image').removeProp('src').hide();
				$('#newImage').val('');
				$('.cancelBtn').hide();
				return false;
			}

			$(document).on('click', '#savephoto', function(){
				$('.validationError').remove();
				var form = $('#photoForm')[0];
				var activity_id = "{{$activity->activity_id}}";
				var galleryid = '{{$activity->gallery_id}}';
				var des = CKEDITOR.instances.photo_description.getData();
				var fd = new FormData(form);
	            fd.append('photo_description', des);
	            fd.append('activity_id', activity_id);
	            fd.append('gallery_id', galleryid);
				$.ajax({
		           url:"{{ url('activities/gallerysave') }}",
		           data: fd,
		           type:"POST",
		           headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),},
		           cache : false,
		            contentType: false,
		            processData : false,
		           success: function(res){
		                if(res.status == 'success'){
		                	alert('New photo is added successfully.');
	                    	$('#addNewGalleryModel').modal('hide');
		                	$('#photoForm')[0].reset();
		                	CKEDITOR.instances.photo_description.setData('');
		                	cancelPreview();
		                	location.reload();
		                }else if(res.status == 'error'){
		                	alert(res.msg);
		                }else if(res.status == 'validation'){
		                	var valid = res.msg;
		                    $.each(valid, function(k,v){
				        		$('#'+k).after('<span class="text-danger validationError" >'+v[0]+'</span>');
				        	});
		                }
		            },error: function(e){
		                alert(e.responseText);
		            }
		        });
				return false;
			});

			$(document).on('click', '.deleteBtn', function(){
				var photo_id = $(this).attr('data-id');
				var activityid = "{{$activity->activity_id}}";
				bootbox.confirm("Do you want to delete this photo?", function(result){
	                if(result == true){
	                	$.ajax({
				            url: '/activities/gallerydelete',
				            data: { photoid:photo_id, activityid:activityid },
				            dataType: 'json',
				            type: 'GET',
				            success: function(res){
				                if(res.status == 'success'){
				                    bootbox.alert(res.message);
				                    location.reload();
				                }else{
				                	bootbox.alert(res.message);
				                }
				                return false;
				            }, error: function(e){
				                console.log(e.responseText);
				                return false;
				            }
				        });
	                }
	            });
			});

		});

	</script>
@endsection