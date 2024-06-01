@extends("master")
@section('styles')
<style type="text/css">
	.selectiveForm .selectDiv:after {margin-top:-6px;}
</style>
@endsection
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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Course Overview</h1>
					<!--end::Title-->
				</div>
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					
				</div>
			</div>
			<!--end::Container-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Post-->
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<div id="kt_content_container" class="container-xxl">
				<div class="row">
					
					<div class="col-md-9">
						<div class="card card-flush">
							<div class="card-body">
								<h3 class="text-dark">Tamil Ariviyal</h3>

								<div class="row">
									<div class="col-md-8">
										<div class="section-text">
											<p>This course showcases the sciences in Tamil as a language, a land, a people, a culture and a knowledgebase. This course is expected to inculcate an urge to learn more about Tamil and from its knowledgebase to see what had made the Tamil region and its people properouos for millennia, so that, the same can be applied relevantly today.</p>

											<p>This package here is meant to assist Faculty teaching this course as well as Students enrolled in this course at an educational institution where this course is being offered as part of the curriculum.</p>

											<p>This package defines a structure by which the Faculty can teach this novel subject in their classes.Data and knowledge from various sources have been compiled, curated and put together as this package to assist the Faculty to take this knowledge to their students along with their own personal experiences and knowledge accumulated through the years.</p>

											<p>For the student, this acts as a refresher point, where they can gain access to the knowledge provided by the Faculty in the same structured manner in which was taught by the Faculty. </p> 
										</div>
									</div>
									<div class="col-md-4">
										<p><b>Topics inside Tamil Ariviyal</b></p>
										<div class="mycourse-topics">
											<ul>
												<li><a href="javascript:;" class="active"><i class="las la-folder"></i> General</a></li>
												<li><a href="javascript:;"><i class="las la-folder"></i> Topic 1 - The Name Bharat</a></li>
												<li><a href="javascript:;"><i class="las la-folder"></i> Topic 2 - Bharat - A Brand</a></li>
												<li><a href="javascript:;"><i class="las la-folder"></i> Topic 3 - Search For India</a></li>
												<li><a href="javascript:;"><i class="las la-folder"></i> Topic 4 - Sea Trade From India</a></li>
												<li><a href="javascript:;"><i class="las la-folder"></i> Topic 5 - Iron and Steel</a></li>
												<li><a href="javascript:;"><i class="las la-folder"></i> Zinc, Copper and Tin</a></li>
												<li><a href="javascript:;"><i class="las la-folder"></i> Cotton and Textiles</a></li>
											</ul>
										</div>
									</div>
								</div>
								
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-flush">
							<div class="card-body">
								<div class="mb-5"><img src="{{URL::asset('media/course-1.jpg')}}" class="image"></div>

								<div class="course-fee-container">
									<h4>Course Fee</h4>
									<ul>
										<li>
											<div class="form-check">
											  	<input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexCheckDefault">
											  	<label class="form-check-label" for="flexCheckDefault">
											    	<i class="las la-rupee-sign"></i> 10,000 <div class="fs-7"><b>1 Semester ( Jan to Jun )</b></div>
											  	</label>
											</div>
										</li>
										<li>
											<div class="form-check">
											  	<input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexCheckDefault">
											  	<label class="form-check-label" for="flexCheckDefault">
											    	<i class="las la-rupee-sign"></i> 10,000 <div class="fs-7"><b>2 Semester ( Jul to Dec )</b></div>
											  	</label>
											</div>
										</li>
									</ul>
								</div>

								<div>
									<a href="{{ url('/courses/my-cart') }}" class="btn btn-primary-light btn-lg w-100">Add to Cart</a>
								</div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#dob').datepicker({
			format: 'dd-mm-yyyy'
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
			 	$('.topic'+id+'Div').show();
			 	click.html('<a href="javascript:;"><i class="las la-minus"></i>');
			 }
			 $('#tabopen').val(id);
		});

		$(document).on('click', '.subopenclose', function(){
			var click = $(this);
			 var id = click.attr('data-id');
			 var opened = $('#subtabopen').val();
			 $('.course-subtopics').hide();
			 $('.subopenclose').html('<a href="javascript:;"><i class="las la-plus"></i>');
			 if(id != opened){
			 	$('.subtopic'+id+'Div').show();
			 	click.html('<a href="javascript:;"><i class="las la-minus"></i>');
			 }
			 $('#subtabopen').val(id);
		});
	});
</script>


@endsection