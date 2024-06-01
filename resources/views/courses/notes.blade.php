@extends("master")

@section('maincontent')

	<style type="text/css">
		.separatePageBox {
			display: none;
		}
	</style>
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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Add Note</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{url('courses/view-course/'.$purchase_course->id)}}" id="kt_help_toggle" class="btn btn-sm btn-primary" >View Course</a>
				</div>
				<!--end::Actions-->
			</div>
			<!--end::Container-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Post-->
		
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<div id="kt_content_container" class="container-xxl">
				
				<div class="card" id="kt_chat_messenger">
					<!--begin::Card header-->
					<div class="card-header pt-3" id="kt_chat_messenger_header">
						<!--begin::Title-->
						<div class="card-title">
							<!--begin::User-->
							<div class="d-flex justify-content-center flex-column me-3">
								<a href="#" class="fs-2 fw-bolder text-gray-900 text-hover-primary me-1 mb-1 lh-1">{{$course->course_name}}</a>
								<!--begin::Info-->
								<!-- <div class="mb-0 lh-1">
									<span class="fs-7 fw-bold text-muted">{{$course->course_name}}</span>
								</div> -->
								<!--end::Info-->
							</div>
							<!--end::User-->
						</div>
						<!--end::Title-->
					</div>
					<!--end::Card header-->
					<!--begin::Card body-->
					<div class="card-body" id="kt_chat_messenger_body">
						<!--begin::Messages-->
						<div class="scroll-y me-n5 pe-5 h-300px h-lg-auto" style="max-height: 446px;" id="notelistBox">


							

						</div>
						<!--end::Messages-->
					</div>
					<!--end::Card body-->
					<!--begin::Card footer-->
					<!-- <div class="card-footer pt-4" id="kt_chat_messenger_footer"> -->
						<!--begin::Input-->
						<!-- <textarea name="course_note" class="form-control form-control-flush mb-3" rows="1" data-kt-element="input" placeholder="Type a message" id="course_note"></textarea> -->
						<!--end::Input-->
						<!--begin:Toolbar-->
						<!-- <div class="d-flex flex-stack"> -->
							<!--begin::Actions-->
							<!-- <div class="d-flex align-items-center me-2">
								<button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button" data-bs-toggle="tooltip" title="" data-bs-original-title="Attachment">
									<i class="bi bi-paperclip fs-3"></i>
								</button>
							</div> -->
							<!--end::Actions-->
							<!--begin::Send-->
							<!-- <a class="btn btn-primary" id="addNoteBtn" data-kt-element="send">Add</a> -->
							<!--end::Send-->
						<!-- </div> -->
						<!--end::Toolbar-->
					<!-- </div> -->
					<!--end::Card footer-->
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

	$(document).on('click', '#addNoteBtn', function(){
		var course_id = $('#course_id').val();
		var purchase_id = $('#purchase_id').val();
		var note = $('#course_note').val();
		$.ajax({
            url:"{{ url('/courses/addnote/post') }}",
            data: { course_id:course_id,purchase_id:purchase_id,note:note },
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            type:"POST",
            success: function(res){
                if(res.status == 'success'){
                	success_msg(res.msg);
                	$('#course_note').val('');
                	getnotes();
                }else if(res.status == 'error'){
                	error_msg(res.msg);
                }
                return false;
            },error: function(e){
                error_msg(e.responseText);
            }
        });
	});

	getnotes();
	function getnotes(){
		console.log('asd');
		var course_id = $('#course_id').val();
		var purchase_id = $('#purchase_id').val();
		$.ajax({
            url:"{{ url('/courses/getnote/list') }}",
            data: { course_id:course_id,purchase_id:purchase_id },
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            type:"POST",
            success: function(res){
                if(res.status == 'success'){
                	$('#notelistBox').html(res.template);
                }else if(res.status == 'error'){
                	error_msg(res.msg);
                }
                return false;
            },error: function(e){
                error_msg(e.responseText);
            }
        });
	}

</script>


@endsection