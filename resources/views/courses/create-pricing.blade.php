@extends("master")
@section('styles')

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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Add Pricing</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				@can('partners-add')
					<div class="d-flex align-items-center gap-2 gap-lg-3">
						<a href="{{url('courses/course-pricing')}}" id="kt_help_toggle" class="btn btn-sm btn-primary">Manage Pricing</a>
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
				<div class="card card-flush">
					<div class="card-body">
						<form action="" class="selectiveForm" method="POST">
							@csrf
							<div class="row">
								<div class="col-md-6">
									<div class="form-group selectDiv">
										<label class="required form-label">Select Course</label>
										<select class="form-control" id="course" name="course"  data-control="select2">
											<option value="">Select</option>
											@foreach($courses as $course)
												<option value="{{$course->id}}" @if($id == $course->id) selected @endif>{{$course->course_name}}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>

							<div class="course-semester" style="display:none" id="courseForm">
								<div class="row d-flex align-items-center">
									<div class="col-md-10">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="required form-label">Pricing Label</label>
													<input type="text" name="priceLabel" id="priceLabel" class="form-control mb-2" placeholder="Pricing Label (Ex. 1st Semester)">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label class="required form-label">Institute Amount</label>
													<input type="text" name="courseAmount" id="courseAmount" class="form-control mb-2" placeholder="Institute Amount">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label class="required form-label">Student Amount</label>
													<input type="text" name="studentAmount" id="studentAmount" class="form-control mb-2" placeholder="Student Amount">
												</div>
											</div>
											<div class="col-md-6">
												<b>From:</b>
												<div class="row">
													<div class="col-md-7">
														<div class="form-group selectDiv">
															<label class="required form-label">Select Month</label>
															<?php 
																$months = array(
																	    'January',
																	    'February',
																	    'March',
																	    'April',
																	    'May',
																	    'June',
																	    'July ',
																	    'August',
																	    'September',
																	    'October',
																	    'November',
																	    'December',
																	);
																?>
															<select class="form-control" name="fromMonth" id="fromMonth">
																<option value="">Select</option>
																@foreach($months as $k=>$v)
																	<option value="{{$k+1}}">{{$v}}</option>
																@endforeach
															</select>
														</div>
													</div>
													<div class="col-md-5">
														<div class="form-group selectDiv">
															<label class="required form-label">Select Year</label>
															<select class="form-control" name="fromYear" id="fromYear">
																<option value="">Select</option>
																@for($i=0; $i<=4; $i++)
																	<?php $year = date('Y') + $i; ?>
																	<option value="{{$year}}">{{$year}}</option>
																@endfor
															</select>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<b>To:</b>
												<div class="row">
													<div class="col-md-7">
														<div class="form-group selectDiv">
															<label class="required form-label">Select Month</label>
															<select class="form-control" name="toMonth" id="toMonth">
																<option value="">Select</option>
																@foreach($months as $k=>$v)
																	<option value="{{$k+1}}">{{$v}}</option>
																@endforeach
															</select>
														</div>
													</div>
													<div class="col-md-5">
														<div class="form-group selectDiv">
															<label class="required form-label">Select Year</label>
															<select class="form-control" name="toYear" id="toYear">
																<option value="">Select</option>
																@for($i=0; $i<=4; $i++)
																	<?php $year = date('Y') + $i; ?>
																	<option value="{{$year}}">{{$year}}</option>
																@endfor
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="modal-footer">
								        	<button type="button" class="btn btn-primary" id="addPrice">Add</button>
								      	</div>
									</div>
								</div>
							</div>
							</form>
							<div id="courseListBox">
								
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.js">
	<script type="text/javascript">
		courseaction();
		$(document).on('change','#course', function(){
			courseaction();
		})
		function courseaction(){
			var course = $('#course').val();
			if(course == ''){
				$('#courseForm').hide();
				$('#courseListBox').html('');
				return false;
			}
			getpricetemplate();
			$('#courseForm').show();
		}

		$(document).on('click','#addPrice', function(){
			var t = $(this); txt = t.text();
			var course_id = $('#course').val();
			var priceLabel = $('#priceLabel').val();
			var courseAmount = $('#courseAmount').val();
			var studentAmount = $('#studentAmount').val();
			var fromMonth = $('#fromMonth').val();
			var fromYear = $('#fromYear').val();
			var toMonth = $('#toMonth').val();
			var toYear = $('#toYear').val();
			t.text('Processing...');
			$.ajax({
                url:"{{ url('/courses/addprice') }}",
                data: { course_id:course_id,priceLabel:priceLabel,courseAmount:courseAmount,studentAmount:studentAmount,fromMonth:fromMonth,fromYear:fromYear,toMonth:toMonth,toYear:toYear },
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                type:"POST",
                success: function(res){
                	t.text(txt);
                    if(res.status == 'success'){
                    	getpricetemplate();
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

		$(document).on('click','.updatePriceBtn', function(){
			var t = $(this); txt = t.text();
			var course_id = $('#course').val();
			var price_id = t.attr('data-id');
			var priceLabel = $('#priceLabel_'+price_id).val();
			var courseAmount = $('#courseAmount_'+price_id).val();
			var studentAmount = $('#studentAmount_'+price_id).val();
			var fromMonth = $('#fromMonth_'+price_id).val();
			var fromYear = $('#fromYear_'+price_id).val();
			var toMonth = $('#toMonth_'+price_id).val();
			var toYear = $('#toYear_'+price_id).val();
			t.text('Processing...');
			$.ajax({
                url:"{{ url('/courses/updateprice') }}",
                data: { course_id:course_id,price_id:price_id,priceLabel:priceLabel,courseAmount:courseAmount,studentAmount:studentAmount,fromMonth:fromMonth,fromYear:fromYear,toMonth:toMonth,toYear:toYear },
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                type:"POST",
                success: function(res){
                	t.text(txt);
                    if(res.status == 'success'){
                    	getpricetemplate();
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

		$(document).on('click','.removePriceBtn', function(){
			var t = $(this); txt = t.text();
			var course_id = $('#course').val();
			var price_id = t.attr('data-id');
			bootbox.confirm('Do you want to remove this price?',function(result) {
				if(result){
					t.text('Processing...');
					$.ajax({
		                url:"{{ url('/courses/removeprice') }}",
		                data: { course_id:course_id,price_id:price_id },
		                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
		                type:"POST",
		                success: function(res){
		                	t.text(txt);
		                    if(res.status == 'success'){
		                    	getpricetemplate();
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
				}
            });
		});

		function getpricetemplate(){
			var course_id = $('#course').val();
			$('#courseListBox').prepend('<div class="text-center"><div class="spinner-border" role="status"></div></div>');
			$.ajax({
                url:"{{ url('/courses/pricetemplate') }}",
                data: { course_id:course_id },
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                type:"POST",
                success: function(res){
                    if(res.status == 'success'){
                    	$('#courseListBox').html(res.template);
                    }else if(res.status == 'error'){
                    	$('#courseListBox').html('');
                    	error_msg(res.msg);
                    }
                    return false;
                },error: function(e){
                	$('#courseListBox').html('');
                    error_msg(e.responseText);
                }
            });
		}
	</script>
@endsection