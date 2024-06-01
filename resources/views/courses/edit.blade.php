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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Edit Course</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				@if(Gate::check('course-view') || Gate::check('course-edit'))
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{url('courses/manage')}}" id="kt_help_toggle" class="btn btn-sm btn-primary" >Manage Courses</a>
				</div>
				@endcan
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
						<form action="{{url('/courses/editpost')}}" class="selectiveForm" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Course Name</label>
										<input type="text" name="courseName" id="courseName" class="form-control mb-2" placeholder="Course Name" value="{{$course->course_name}}">
										@if($errors->has("courseName"))
											<span id="name-error" class="help-block">{!! $errors->first("courseName") !!}</span>
										@endif
									</div>
								</div>
								<input type="hidden" name="edit_id" id="edit_id" value="{{$course->id}}">
								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Course Description</label>
										<textarea name="description" id="description" class="form-control mb-2 summernote" placeholder="Course Description" rows="3">{{$course->description}}</textarea>
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
										@if($course->image)
										<div class="mt-2"><b>Uploaded Image</b></div>
										<div class="uploaded-img"><img src="{{asset($course->image)}}"></div>
										@endif
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group selectDiv">
										<label class="required form-label">Course Category</label>
										<select name="category" id="category" class="form-control form-select-solid form-select-lg fw-bold" data-control="select2">
											<option value="">Select</option>
											@foreach($category as $cat)
												<option value="{{$cat->id}}" <?php if($course->category == $cat->id){ echo 'selected'; } ?>>{{$cat->cat_name}}</option>
											@endforeach
										</select>
										@if($errors->has("category"))
											<span id="name-error" class="help-block">{!! $errors->first("category") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group selectDiv">
										<label class="required form-label">Course Subject</label>
										<select name="subject" id="Subject" class="form-control form-select-solid form-select-lg fw-bold" data-control="select2">
											<option value="">Select</option>
											@foreach($subject as $sub)
												<option value="{{$sub->id}}" <?php if($course->subject == $sub->id){ echo 'selected'; } ?>>{{$sub->name}}</option>
											@endforeach
										</select>
										@if($errors->has("subject"))
											<span id="name-error" class="help-block">{!! $errors->first("subject") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group selectDiv">
										<label class="required form-label">Status</label>
										<select name="status" id="status" class="form-control form-select-solid form-select-lg fw-bold" data-control="select2">
											<option value="">Select</option>
											<option value="active" <?php if($course->status == 'active'){ echo 'selected'; } ?>>Active</option>
											<option value="inactive" <?php if($course->status == 'inactive'){ echo 'selected'; } ?>>Inactive</option>
										</select>
										@if($errors->has("status"))
											<span id="name-error" class="help-block">{!! $errors->first("status") !!}</span>
										@endif
									</div>
								</div>
							</div>

							<div class="d-flex justify-content-end py-6">
								<button type="reset" class="btn btn-light btn-active-light-primary me-2">Reset</button>
								<button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save </button>
							</div>

							</form>
							<div class="d-flex justify-content-start mb-2">
								<a href="javascript:;" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNewTopic"><i class="las la-plus"></i> Add Topic</a>
							</div>

							<div id="topicTemplateBox">
								
							</div>

							<!-- <div class="course-topics">
								<div class="course-topics-header">
									<div>Topic 1 - The Name Bharat</div>
									<div class="openclose" data-id="1"><a href="javascript:;"><i class="las la-minus"></i></a></div>
								</div>
								<div class="course-body topic1Div">
									<div class="mb-2 d-flex justify-content-end"><a href="javascript:;" class="btn btn-info btn-xs" data-bs-toggle="modal" data-bs-target="#addTopicSection"><i class="las la-plus"></i> Add Topic Sections</a></div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="required form-label">Topic Name</label>
												<input type="text" name="StaffName" class="form-control mb-2" placeholder="Course Topic Name" value="Topic 1 - The Name Bharat">
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label class="required form-label">Topic Description</label>
												<textarea name="description" id="description" class="form-control mb-2" placeholder="Topic Description" rows="3"></textarea>
											</div>
										</div>
									</div>

									<div class="course-body-">
										<div class="course-innertopics-header">
											<div>Topic 2.1 - Lectures</div>
											<div class="subopenclose" data-id="1"><a href="javascript:;"><i class="las la-plus"></i></a></div>
										</div>
										<div class="course-subtopics subtopic1Div" style="display: none;">
											<div class="col-md-12">
												<div class="form-group">
													<label class="required form-label">Topic Name</label>
													<input type="text" name="StaffName" class="form-control mb-2" value="Topic 2 - Lectures">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label class="required form-label">Title 1</label>
													<input type="text" name="StaffName" class="form-control mb-2" value="The Name India">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label class="required form-label">Video 1</label>
													<textarea name="description" id="description" class="form-control mb-2" placeholder="Topic Description" rows="3"><iframe src="https://player.vimeo.com/video/434081100" width="640" height="564" align="center" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe></textarea>
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label class="required form-label">Title 2</label>
													<input type="text" name="StaffName" class="form-control mb-2" value="The Geography of Bharat">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label class="required form-label">Video 2</label>
													<textarea name="description" id="description" class="form-control mb-2" placeholder="Topic Description" rows="3"><iframe src="https://player.vimeo.com/video/434081100" width="640" height="564" align="center" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe></textarea>
												</div>
											</div>
										</div>
									</div>


									<div class="course-body-">
										<div class="course-innertopics-header">
											<div>Topic 2.2 - Science</div>
											<div class="subopenclose" data-id="2"><a href="javascript:;"><i class="las la-plus"></i></a></div>
										</div>
										<div class="course-subtopics subtopic2Div" style="display: none;">
											<div class="col-md-12">
												<div class="form-group">
													<label class="required form-label">Topic Name</label>
													<input type="text" name="StaffName" class="form-control mb-2" value="Topic 2 - Science">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label class="required form-label">Title 1</label>
													<input type="text" name="StaffName" class="form-control mb-2" value="The Name India">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label class="required form-label">Video 1</label>
													<textarea name="description" id="description" class="form-control mb-2" placeholder="Topic Description" rows="3"><iframe src="https://player.vimeo.com/video/434081100" width="640" height="564" align="center" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe></textarea>
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label class="required form-label">Title 2</label>
													<input type="text" name="StaffName" class="form-control mb-2" value="The Geography of Bharat">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label class="required form-label">Video 2</label>
													<textarea name="description" id="description" class="form-control mb-2" placeholder="Topic Description" rows="3"><iframe src="https://player.vimeo.com/video/434081100" width="640" height="564" align="center" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe></textarea>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div> -->

							<!-- Topic 2 -->
							<!-- <div class="course-topics">
								<div class="course-topics-header">
									<div>Topic 2 - The Name India</div>
									<div class="openclose" data-id="2"><a href="javascript:;"><i class="las la-plus"></i></a></div>
								</div>
								<div class="course-body topic2Div" style="display:none;">
									<div class="mb-2 d-flex justify-content-end"><a href="javascript:;" class="btn btn-info btn-xs" data-bs-toggle="modal" data-bs-target="#addTopicSection"><i class="las la-plus"></i> Add Topic Sections</a></div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="required form-label">Topic Name</label>
												<input type="text" name="StaffName" class="form-control mb-2" placeholder="Course Topic Name" value="Topic 2 - The Name India">
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label class="required form-label">Topic Description</label>
												<textarea name="description" id="description" class="form-control mb-2" placeholder="Topic Description" rows="3"></textarea>
											</div>
										</div>
									</div>

									<div class="course-body-">
										<div class="course-innertopics-header">
											<div>Topic 2.1 - Lectures</div>
											<div class="subopenclose" data-id="3"><a href="javascript:;"><i class="las la-minus"></i></a></div>
										</div>
										<div class="course-subtopics subtopic3Div" style="display: none;">
											<div class="col-md-12">
												<div class="form-group">
													<label class="required form-label">Topic Name</label>
													<input type="text" name="StaffName" class="form-control mb-2" value="Topic 2 - Lectures">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label class="required form-label">Title 1</label>
													<input type="text" name="StaffName" class="form-control mb-2" value="The Name India">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label class="required form-label">Video 1</label>
													<textarea name="description" id="description" class="form-control mb-2" placeholder="Topic Description" rows="3"><iframe src="https://player.vimeo.com/video/434081100" width="640" height="564" align="center" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe></textarea>
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label class="required form-label">Title 2</label>
													<input type="text" name="StaffName" class="form-control mb-2" value="The Geography of Bharat">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label class="required form-label">Video 2</label>
													<textarea name="description" id="description" class="form-control mb-2" placeholder="Topic Description" rows="3"><iframe src="https://player.vimeo.com/video/434081100" width="640" height="564" align="center" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe></textarea>
												</div>
											</div>
										</div>
									</div>


									<div class="course-body-">
										<div class="course-innertopics-header">
											<div>Topic 2.2 - Science</div>
											<div class="subopenclose" data-id="4"><a href="javascript:;"><i class="las la-minus"></i></a></div>
										</div>
										<div class="course-subtopics subtopic4Div" style="display: none;">
											<div class="col-md-12">
												<div class="form-group">
													<label class="required form-label">Topic Name</label>
													<input type="text" name="StaffName" class="form-control mb-2" value="Topic 2 - Science">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label class="required form-label">Title 1</label>
													<input type="text" name="StaffName" class="form-control mb-2" value="The Name India">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label class="required form-label">Video 1</label>
													<textarea name="description" id="description" class="form-control mb-2" placeholder="Topic Description" rows="3"><iframe src="https://player.vimeo.com/video/434081100" width="640" height="564" align="center" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe></textarea>
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label class="required form-label">Title 2</label>
													<input type="text" name="StaffName" class="form-control mb-2" value="The Geography of Bharat">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label class="required form-label">Video 2</label>
													<textarea name="description" id="description" class="form-control mb-2" placeholder="Topic Description" rows="3"><iframe src="https://player.vimeo.com/video/434081100" width="640" height="564" align="center" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe></textarea>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div> -->

							<!-- Add Topic -->
							<div class="modal fade" id="addNewTopic" tabindex="-1" aria-labelledby="addNewTopicLabel" aria-hidden="true">
							  	<div class="modal-dialog modal-dialog-centered modal-lg">
								    <div class="modal-content">
								      	<div class="modal-header">
								        	<h5 class="modal-title" id="addNewTopicLabel">Add New Topic</h5>
								      	</div>
								      	<div class="modal-body">
									        <div class="form-group">
												<label class="required form-label">Topic Name</label>
												<input type="text" name="topicName" id="topicName" class="form-control mb-2" placeholder="Course Topic Name" value="">
											</div>

											<div class="form-group">
												<label class="required form-label">Topic Description</label>
												<textarea name="topicDescription" id="topicDescription" class="form-control mb-2 summernote" placeholder="Topic Description" rows="3"></textarea>
											</div>
								      	</div>
								      	<div class="modal-footer">
								        	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
								        	<button type="button" id="addTopicBtn" data-parent="0" class="btn btn-primary">Submit</button>
								      	</div>
								    </div>
							  	</div>
							</div>

							<!-- Add Sub Topic -->
							<div class="modal fade" id="addTopicSection" tabindex="-1" aria-labelledby="addTopicSectionLabel" aria-hidden="true">
							  	<div class="modal-dialog modal-dialog-centered modal-lg">
								    <div class="modal-content">
								      	<div class="modal-header">
								        	<h5 class="modal-title" id="addTopicSectionLabel">Add New Sub Topic</h5>
								      	</div>
								      	<div class="modal-body">
									        <div class="form-group">
												<label class="required form-label">Topic Name</label>
												<input type="text" name="subTopicName" id="subTopicName" class="form-control mb-2" placeholder="Sub Topic Name" value="">
											</div>
											<input type="hidden" name="sub_parent_id" id="sub_parent_id" value="">
											<!-- <h6>Select Required fields for this section</h6>
											<div class="form-group">
												<div class="form-check mb-3">
												  	<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
												  	<label class="form-check-label" for="flexCheckDefault">
												    	Input Field
												  	</label>
												</div>
												<div class="form-check mb-3">
												  	<input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
												  	<label class="form-check-label" for="flexCheckChecked">
												    	Text Editor
												  	</label>
												</div>
												<div class="form-check mb-3">
												  	<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
												  	<label class="form-check-label" for="flexCheckDefault">
												    	Text Area
												  	</label>
												</div>
											</div> -->
								      	</div>
								      	<div class="modal-footer">
								        	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
								        	<button type="button" class="btn btn-primary" id="addSubTopicBtn">Submit</button>
								      	</div>
								    </div>
							  	</div>
							</div>

							<!-- Add Sub Topic Field -->
							<div class="modal fade" id="addTopicFieldSection" tabindex="-1" aria-labelledby="addTopicSectionLabel" aria-hidden="true">
							  	<div class="modal-dialog modal-dialog-centered modal-lg">
								    <div class="modal-content">
								      	<div class="modal-header">
								        	<h5 class="modal-title" id="addTopicSectionLabel">Add Field</h5>
								      	</div>
								      	<div class="modal-body">
								      		<div class="form-group">
												<label class="required form-label">Title</label>
												<input type="text" name="topic_field_title" id="topic_field_title" class="form-control">
											</div>
									        <div class="form-group">
												<label class="required form-label">Select Field</label>
												<select class="form-control" id="topic_field_type" name="topic_field_type">
													<option value="text-area">Text Area</option>
													<option value="text-editor">Text Editor</option>
													<option value="audio">Audio</option>
													<option value="video">Video</option>
													<option value="iframe">IFrame</option>
													<option value="pdf">PDF</option>
												</select>
											</div>
											<input type="hidden" name="sub_field_parent_id" id="sub_field_parent_id" value="">
								      	</div>
								      	<div class="modal-footer">
								        	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
								        	<button type="button" class="btn btn-primary" id="addSubTopicFieldBtn">Add</button>
								      	</div>
								    </div>
							  	</div>
							</div>
						
					</div>
				</div>
			</div>
		</div>
		<!--end::Post-->
	</div>
	<!--end::Content-->

	<input type="hidden" name="tabopen" value="" id="tabopen">
	<input type="hidden" name="subtabopen" value="" id="subtabopen">
@endsection
@section('styles')
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js
"></script> -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#dob').datepicker({
			format: 'dd-mm-yyyy'
		});

		//Summernote
		$('.summernote').summernote({
		    callbacks: {
		        onImageUpload: function(image) {
		            uploadImage(image[0]);
		        }
		    }
		});

		$(document).on('click', '.openSubTopicModal', function(){
			$('#sub_parent_id').val($(this).attr('data-id'));
			$('#addTopicSection').modal('show');
		});
		$(document).on('click', '.openSubTopicFieldModal', function(){
			$('#sub_field_parent_id').val($(this).attr('data-id'));
			$('#addTopicFieldSection').modal('show');
		});

		$(document).on('click', '.openclose', function(){
			var click = $(this);
			 var id = click.attr('data-id');
			 var opened = $('#tabopen').val();
			 $('.course-body').hide();
			 $('.openclose').html('<a href="javascript:;"><i class="las la-plus"></i>');
			 $('.course-subtopics').hide();
			 $('.subopenclose').html('<a href="javascript:;"><i class="las la-plus"></i>');
			 if(id != opened){
			 	$('#tabopen').val(id);
			 	$('.topic'+id+'Div').show();
			 	click.html('<a href="javascript:;"><i class="las la-minus"></i>');
			 	var topic_id = click.attr('data-topic');
			 	getsubtopics(topic_id);
			 }else{
			 	$('.topic'+id+'Div').hide();
			 	$('#tabopen').val('');
			 }
		});

		$(document).on('click', '.subopenclose', function(){
			var click = $(this);
			 var id = click.attr('data-id');
			 var opened = $('#subtabopen').val();
			 $('.course-subtopics').hide();
			 $('.subopenclose').html('<a href="javascript:;"><i class="las la-plus"></i>');
			 if(id != opened){
			 	$('#subtabopen').val(id);
			 	$('.subtopic'+id+'Div').show();
			 	click.html('<a href="javascript:;"><i class="las la-minus"></i>');
			 	var topic_id = click.attr('data-topic');
			 	gettopicfields(topic_id);
			 }else{
			 	$('.subtopic'+id+'Div').hide();
			 	$('#subtabopen').val('');
			 }
			 
		});

		$(document).on('click','#addTopicBtn', function(){
			var t = $(this); txt = t.text();
			var topic_name = $('#topicName').val();
			var topic_desc = $('#topicDescription').val();
			var course_id = $('#edit_id').val();
			var parent_id = t.attr('data-parent');
			t.text('Processing...');
			$.ajax({
                url:"{{ url('/courses/addtopic') }}",
                data: { topic_name: topic_name,topic_desc:topic_desc,parent_id:parent_id,course_id:course_id },
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                type:"POST",
                success: function(res){
                	t.text(txt);
                    if(res.status == 'success'){
                    	$('#topicName').val('');
                    	$('#topicDescription').val('');
                    	gettopics();
                    	success_msg(res.msg);
                    }else if(res.status == 'error'){
                    	 error_msg(res.msg);
                    }
                    return false;
                },error: function(e){
                	t.text(txt);
                    error_msg(e.responseText);
                }
            });
		});
		gettopics();
		function gettopics(tid=0){
			console.log(tid);
			var course_id = $('#edit_id').val();
			$('#topicTemplateBox').append(`<div class="text-center"><div class="spinner-border" role="status"></div></div>`);
			$.ajax({
                url:"{{ url('/courses/gettopic/template') }}",
                data: { course_id:course_id },
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                type:"POST",
                success: function(res){
                    if(res.status == 'success'){
                    	$('#topicTemplateBox').html(res.template);
                    	if(tid != 0){
                    		console.log(tid);
                    		$('#tabopen').val('');
                    		setTimeout(function(){ $('.openclose_'+tid).click(); }, 1000);
                    	}
                    }else if(res.status == 'error'){
                    	$('#topicTemplateBox').html('');
                    	 error_msg(res.msg);
                    }
                    return false;
                },error: function(e){
                	$('#topicTemplateBox').html('');
                    error_msg(e.responseText);
                }
            });
		}
		$(document).on('click','#addSubTopicBtn', function(){
			var t = $(this); txt = t.text();
			var topic_name = $('#subTopicName').val();
			var course_id = $('#edit_id').val();
			var parent_id = $('#sub_parent_id').val();
			t.text('Processing...');
			$.ajax({
                url:"{{ url('/courses/addsubtopic') }}",
                data: { topic_name: topic_name,parent_id:parent_id,course_id:course_id },
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                type:"POST",
                success: function(res){
                	t.text(txt);
                    if(res.status == 'success'){
                    	$('#subTopicName').val('');
                    	getsubtopics(parent_id);
                    	success_msg(res.msg);
                    }else if(res.status == 'error'){
                    	 error_msg(res.msg);
                    }
                    return false;
                },error: function(e){
                	t.text(txt);
                    error_msg(e.responseText);
                }
            });
		});
		function getsubtopics(topic_id){
			var course_id = $('#edit_id').val();
			$('.subTopicTemplate_'+topic_id).append('<div class="text-center"><div class="spinner-border" role="status"></div></div>');
			$.ajax({
                url:"{{ url('/courses/getsubtopic/template') }}",
                data: { course_id:course_id,topic_id:topic_id },
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                type:"POST",
                success: function(res){
                    if(res.status == 'success'){
                    	$('.subTopicTemplate_'+topic_id).html(res.template);
                    	$('.summernote').summernote();
                    }else if(res.status == 'error'){
                    	$('.subTopicTemplate_'+topic_id).html('');
                    	error_msg(res.msg);
                    }
                    return false;
                },error: function(e){
                	$('.subTopicTemplate_'+topic_id).html('');
                    error_msg(e.responseText);
                }
            });
		}

		$(document).on('click','#addSubTopicFieldBtn', function(){
			var t = $(this); txt = t.text();
			var field_title = $('#topic_field_title').val();
			var field_type = $('#topic_field_type').val();
			var course_id = $('#edit_id').val();
			var topic_id = $('#sub_field_parent_id').val();
			t.text('Processing...');
			$.ajax({
                url:"{{ url('/courses/addtopicfield') }}",
                data: { field_type: field_type,topic_id:topic_id,course_id:course_id, field_title: field_title },
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                type:"POST",
                success: function(res){
                	t.text(txt);
                    if(res.status == 'success'){
                    	gettopicfields(topic_id);
                    	success_msg(res.msg);
                    }else if(res.status == 'error'){
                    	 error_msg(res.msg);
                    }
                    return false;
                },error: function(e){
                	t.text(txt);
                    error_msg(e.responseText);
                }
            });
		});

		function gettopicfields(topic_id){
			var course_id = $('#edit_id').val();
			$('.topicFieldTemplate_'+topic_id).append('<div class="text-center"><div class="spinner-border" role="status"></div></div>');
			$.ajax({
                url:"{{ url('/courses/gettopicfield/template') }}",
                data: { course_id:course_id,topic_id:topic_id },
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                type:"POST",
                success: function(res){
                    if(res.status == 'success'){
                    	$('.topicFieldTemplate_'+topic_id).html(res.template);

                    	$('.summernote').summernote({
						    height: 100,
						    toolbar: [
						        ['style', ['bold', 'italic', 'underline', 'clear']],
						        ['font', ['strikethrough', 'superscript', 'subscript']],
						        ['fontsize', ['fontsize']],
						        ['color', ['color']],
						        ['para', ['ul', 'ol', 'paragraph']],
						        ['height', ['height']]
						    ]
						});

                    }else if(res.status == 'error'){
                    	$('.topicFieldTemplate_'+topic_id).html('');
                    	error_msg(res.msg);
                    }
                    return false;
                },error: function(e){
                	$('.topicFieldTemplate_'+topic_id).html('');
                    error_msg(e.responseText);
                }
            });
		}

		$(document).on('click','.updateParentFieldBtn', function(){
			var t = $(this); txt = t.text();
			var topic_id = t.attr('data-id');
			var course_id = $('#edit_id').val();
			var topic_name = $('#updateTopic_'+topic_id).val();
			var description = $('#updateDescription_'+topic_id).val();

			t.text('Processing...');
			$.ajax({
                url:"{{ url('/courses/updateparentfields') }}",
                data: { topic_id:topic_id,course_id:course_id,topic_name:topic_name,description:description },
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                type:"POST",
                success: function(res){
                	t.text(txt);
                    if(res.status == 'success'){
                    	gettopics(topic_id);
                    	success_msg(res.msg);
                    }else if(res.status == 'error'){
                    	 error_msg(res.msg);
                    }
                    return false;
                },error: function(e){
                	t.text(txt);
                    error_msg(e.responseText);
                }
            });
		});

		$(document).on('click','.updateSubTopicFieldBtn', function(){
			var t = $(this); txt = t.text();
			var topic_id = t.attr('data-id');
			var course_id = $('#edit_id').val();
			var dynamic_field = $('#fieldForm_'+topic_id).serializeArray();
			t.text('Processing...');
			$.ajax({
                url:"{{ url('/courses/updatedynamicfields') }}",
                data: { topic_id:topic_id,course_id:course_id,dynamic_field:dynamic_field },
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                type:"POST",
                success: function(res){
                	t.text(txt);
                    if(res.status == 'success'){
                    	gettopicfields(topic_id);
                    	success_msg(res.msg);
                    }else if(res.status == 'error'){
                    	 error_msg(res.msg);
                    }
                    return false;
                },error: function(e){
                	t.text(txt);
                    error_msg(e.responseText);
                }
            });
		});

	});
</script>


@endsection