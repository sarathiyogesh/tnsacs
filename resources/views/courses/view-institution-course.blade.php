<?php 
	use App\Models\Category;
	use App\Models\Subject;
	use App\Models\Coursetopic;
	use App\Models\Coursecompletedstatus;
?>
@extends("master")
@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" crossorigin="anonymous">
<style type="text/css">
	.selectiveForm .selectDiv:after {margin-top:-6px;}
</style>
@endsection
@section('maincontent')
	<input type="hidden" name="course_id" id="course_id" value="{{$course->id}}">
	<input type="hidden" name="purchase_id" id="purchase_id" value="{{$purchase_course->id}}">
	<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<!--begin::Toolbar-->
		<div class="toolbar" id="kt_toolbar">
			<!--begin::Container-->
			<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
				<!--begin::Page title-->
				<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
					<!--begin::Title-->
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">{{$course->course_name}}</h1>
					<!--end::Title-->
				</div>
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="javascript:;" id="updateFaculty" class="btn btn-xs btn-primary"><i class="las la-plus"></i> View Faculty</a>
					<a href="{{url('courses/notes/'.$purchase_course->id)}}" class="btn btn-xs btn-primary"><i class="las la-plus"></i> View Course Notes</a>
					<span class="px-5">|</span>
					<b>Course Progress:</b>
					<div class="progress w-200px">
					  <div class="progress-bar" role="progressbar" style="width: {{Coursecompletedstatus::completedpercentage($course->id)}}%;" aria-valuenow="{{Coursecompletedstatus::completedpercentage($course->id)}}" aria-valuemin="0" aria-valuemax="100">{{Coursecompletedstatus::completedpercentage($course->id)}}%</div>
					</div>
				</div>
			</div>
			<!--end::Container-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Post-->
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<div id="kt_content_container" class="container-xxl">
				<div class="row">
					<div class="col-md-3">
						<div class="card card-flush">
							<div class="card-body">
								<div class="mycourse-topics">
									<ul>
										@foreach($parent_topic as $parent)
										<li><a href="javascript:;" class="active viewTopic" data-id="{{$parent->id}}" data-type="parent"><i class="las la-folder"></i> {{$parent->topic_name}}</a></li>
										<?php
											$sub_topics = Coursetopic::where('status','active')->where('parent_id',$parent->id)->get();
										?>
										@foreach($sub_topics as $sub)
											<li><a href="javascript:;" class="viewTopic" data-id="{{$parent->id}}" data-type="child" data-child="{{$sub->id}}"><i class="las la-folder"></i>{{$sub->topic_name}}</a></li>
										@endforeach
										@endforeach
									</ul>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-9">
						<div class="card card-flush">
							<div class="card-body" id="viewTopicTemplate">
								<b>Select topic</b>
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
	<input type="hidden" name="tabopen" value="" id="tabopen">
	<input type="hidden" name="subtabopen" value="" id="subtabopen">


	<div class="modal fade" id="facultyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">View Faculty</h5>
	        <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form>
	          <div class="form-group">
	            <label for="message-text" class="col-form-label">Faculty:</label>
	            <select name="faculty[]" id="faculty" class="form-control" multiple>
	            	@foreach($faculties as $fa)
	            		<option value="{{ $fa->id }}" @if(in_array($fa->id, $selected_faculties)) selected @endif>{{ $fa->name }}</option>
	            	@endforeach
	            </select>
	          </div>
	        </form>
	      </div>
	      <!-- <div class="modal-footer">
	        <button type="button" class="btn btn-secondary closeModal" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary" id="saveFaculty">Update</button>
	      </div> -->
	    </div>
	  </div>
	</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#dob').datepicker({
			format: 'dd-mm-yyyy'
		});

		$(document).on('click', '#saveFaculty', function(){
			var faculty = $('#faculty').val();
			var course_id = "{{ $purchase_course->course_id }}";
			var meta_id = "{{ $purchase_course->id }}";
			if(faculty.length == 0){
				error_msg('Please select course faculty');
				return false;
			}
			faculty = JSON.stringify(faculty);
			$.ajax({
                url:"{{ url('/courses/viewtopic/updatefaculty') }}",
                data: { course_id:course_id,faculty:faculty, meta_id: meta_id },
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                type:"POST",
                success: function(res){
                    if(res.status == 'success'){
                    	success_msg(res.message);
                    	$('#facultyModal').modal('hide');
                    }else if(res.status == 'error'){
                    	error_msg(res.message);
                    }
                    return false;
                },error: function(e){
                    error_msg(e.responseText);
                }
            });
		});

		$(document).on('click', '#updateFaculty', function(){
			$('#facultyModal').modal('show');
		});

		$(document).on('click', '.closeModal', function(){
			$('#facultyModal').modal('hide');
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
			 }else{
			 	$('#tabopen').val('');
			 	$('.topic'+id+'Div').hide();
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
			 	//var topic_id = click.attr('data-topic');
			 	//gettopicfields(topic_id);
			 }else{
			 	$('.subtopic'+id+'Div').hide();
			 	$('#subtabopen').val('');
			 }
		});

		$(document).on('click', '.viewTopic', function(){
			child_id = 0;
			if($(this).attr('data-type') == 'child'){
				child_id = $(this).attr('data-child');
				var scrollPos =  $("#viewTopicTemplate").offset().top - 100;
 				$(window).scrollTop(scrollPos);
			}else{
				var scrollPos =  $("#viewTopicTemplate").offset().top - 100;
 				$(window).scrollTop(scrollPos);
				$('#viewTopicTemplate').focus();
			}
			getsubtopics($(this).attr('data-id'),child_id);
		});

		function getsubtopics(topic_id,child_id=0){
			var course_id = $('#course_id').val();
			var purchase_id = $('#purchase_id').val();
			$('#viewTopicTemplate').html('');
			$('#viewTopicTemplate').prepend('<div class="text-center"><div class="spinner-border" role="status"></div></div>');
			$.ajax({
                url:"{{ url('/courses/viewtopic/template') }}",
                data: { course_id:course_id,topic_id:topic_id,purchase_id:purchase_id },
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                type:"POST",
                success: function(res){
                    if(res.status == 'success'){
                    	$('#viewTopicTemplate').html(res.template);
                    	if(child_id != 0){
                    		$('#subtabopen').val('');
                    		setTimeout(function(){ $('.subopenclose_'+child_id).click(); }, 1000);
                    	}
                    }else if(res.status == 'error'){
                    	$('#viewTopicTemplate').html('');
                    	error_msg(res.msg);
                    }
                    return false;
                },error: function(e){
                	$('#viewTopicTemplate').html('');
                    error_msg(e.responseText);
                }
            });
		}

		// $(document).on('click', '.markAsCompletedBtn', function(){
		// 	var course_id = $('#course_id').val();
		// 	var purchase_id = $('#purchase_id').val();
		// 	var topic_id = $(this).val();
		// 	if($(this).prop('checked')){
		// 		topic_selected = 'yes';
		// 	}else{
		// 		topic_selected = 'no';
		// 	}
		// 	$.ajax({
        //         url:"{{ url('/courses/viewtopic/updatecompletedstatus') }}",
        //         data: { course_id:course_id,topic_id:topic_id,purchase_id:purchase_id,topic_selected:topic_selected },
        //         headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        //         type:"POST",
        //         success: function(res){
        //             if(res.status == 'success'){
        //             	success_msg(res.msg);
        //             	$('.progress-bar').text(res.percentage+'%').width(res.percentage+'%').attr('aria-valuenow',res.percentage);
        //             }else if(res.status == 'error'){
        //             	error_msg(res.msg);
        //             }
        //             return false;
        //         },error: function(e){
        //             error_msg(e.responseText);
        //         }
        //     });
		// });
	});
</script>


@endsection