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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Students Course Report</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="javascript:;" class="btn btn-sm btn-primary" id="excelexport" >Export Excel</a>
				</div>
			</div>
			<!--end::Container-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Post-->
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<div id="kt_content_container" class="container-xxl">

				<div class="card card-flush mb-4">
					<div class="card-header py-5 gap-2 gap-md-5">
						<div class="card-header-title">Search by Filter</div>
						<!--begin::Search-->
						<form id="bookingForm" method="GET" action="">
							<div class="row">
								<div class="col-md-3 mb-3">
									<div class="d-flex align-items-center position-relative">
										<input type="text" autocomplete="off" class="form-control form-control-solid ps-14" placeholder="Subscription ID" id="subscription_id" name="subscription_id" value="">
									</div>
								</div>
								<div class="col-md-3 mb-3">
									<div class="d-flex align-items-center position-relative">
										<input type="text" autocomplete="off" class="form-control form-control-solid ps-14" placeholder="Purchase Date From" id="date_from" name="date_from" value="">
									</div>
								</div>
								<div class="col-md-3 mb-3">
									<div class="d-flex align-items-center position-relative">
										<input type="text" autocomplete="off" class="form-control form-control-solid ps-14" placeholder="Purchase Date To" id="date_to" name="date_to" value="">
									</div>
								</div>

								<div class="col-md-3 mb-3">
									<div class="d-flex align-items-center position-relative">
										<select name="category" id="category" class="form-control form-control-solid ps-14">
				                            <option value="">Select Catgory</option>
				                            @foreach($categories as $cat)
				                            	<option value="{{ $cat->id }}">{{ $cat->cat_name }}</option>
				                            @endforeach
				                        </select>
									</div>
								</div>

								<div class="col-md-3 mb-3">
									<div class="d-flex align-items-center position-relative">
										<select name="institution" id="institution" class="form-control form-control-solid ps-14">
				                            <option value="">Select Institution</option>
				                            @foreach($institutions as $in)
			                                    <option value="{{$in->id}}">{{$in->name}}</option>
			                                @endforeach
				                        </select>
									</div>
								</div>

								<div class="col-md-3 mb-3">
									<div class="d-flex align-items-center position-relative">
										<select name="student" id="student" class="form-control form-control-solid ps-14">
				                            <option value="">Select Student</option>
				                            @foreach($students as $st)
			                                    <option value="{{$st->id}}">{{$st->name}}</option>
			                                @endforeach
				                        </select>
									</div>
								</div>
								<div class="col-md-2">
									<button type="button" class="btn btn-primary btn-sm searchbtn">Search</button>&nbsp;
									<button type="button" class="btn btn-primary btn-sm ClearBtn">Clear</button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="card card-flush">
					<!--begin::Card body-->
					<div class="card-body">
						<!--begin::Table-->
						<div class="alert alert-danger errorMsg-show" style="display:none;"></div>
						<div id="kt_ecommerce_products_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
							<div class="table-responsive showTable">
							</div>
						</div>
					</div>
					<!--end::Card body-->
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

			$('#date_from, #date_to').datepicker({
				format: 'dd-mm-yyyy'
			});

			getTable();

			$(document).on('click', '.searchbtn', function(){
				getTable();
			});

			$(document).on('click', '.pagination a', function(event){
		        event.preventDefault();
		        var page = $(this).attr('href').split('page=')[1];
		        $('li').removeClass('active');
		        $(this).parent().addClass('active');
		        getTable(page);
	    	});

			function getTable(page = 1){
				var date_from = $('#date_from').val();
				var date_to = $('#date_to').val();
				var subscription_id = $('#subscription_id').val();
				var institution = $('#institution').val();
				var category = $('#category').val();
				var student = $('#student').val();
				$.ajax({
	                url:"{{ url('report/student-course/get') }}",
	                data: { date_from:date_from, date_to:date_to, subscription_id:subscription_id, category:category,  page:page, institution: institution, student:student },
	                type:"GET",
	                success: function(res){
	                    if(res.status == 'success'){
	                    	$('.showTable').html('').html(res.data);
	                    }else if(res.status == 'error'){
	                    	$('.errorMsg-show').html(res.msg).show();
	                    }
	                },error: function(e){
	                    $('.errorMsg-show').html(e.responseText).show();
	                }
	            });
	            return false;
			}

		});

		$(document).on('click', '.ClearBtn', function(){
			//$('#bookingForm')[0].reset();
			$(':input','#myform')
			  .not(':button, :submit, :reset, :hidden')
			  .val('')
			  .prop('checked', false)
			  .prop('selected', false);
			location.reload();
			return false;
		});

		$(document).on("click", "#excelexport", function(){
	    	var date_from = $('#date_from').val();
			var date_to = $('#date_to').val();
			var subscription_id = $('#subscription_id').val();
			var institution = $('#institution').val();
			var category = $('#category').val();
			var student = $('#student').val();
	        var url = "/report/student-course/excel";
	        url = url+'?';
	        if(date_from != ''){
	          url = url+'date_from='+date_from;
	        }

	        if(date_to != ''){
	          url = url+'&&date_to='+date_to;
	        }
	        if(subscription_id != ''){
	          url = url+'&&subscription_id='+subscription_id;
	        }
	        if(category != ''){
	          url = url+'&&category='+category;
	        }
	        if(institution != ''){
	          url = url+'&&institution='+institution;
	        }
	        if(student != ''){
	          url = url+'&&student='+student;
	        }
	        var win = window.open(url);
	      	win.focus();
			return false;
	    });

	</script>
@endsection