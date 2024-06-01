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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">View All Courses</h1>
					<!--end::Title-->
				</div>
			</div>
			<!--end::Container-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Post-->
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<div id="kt_content_container" class="container-xxl">

				<div class="card card-flush mb-4 selectiveForm">
					<div class="card-header py-5 gap-2 gap-md-5">
						<div class="card-header-title">Search by Filter</div>
						<div class="row">
							<div class="col-md-3">
								<div class="selectDiv">
									<select name="category" id="category" class="form-control form-select-solid" data-control="select2">
										<option value="">Category</option>
										@foreach($category as $cat)
											<option value="{{$cat->id}}" <?php if(old('category') == $cat->id){ echo 'selected'; } ?>>{{$cat->cat_name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="selectDiv">
									<select name="subject" id="subject" class="form-control form-select-solid" data-control="select2">
										<option value="">Subject</option>
										@foreach($subject as $sub)
											<option value="{{$sub->id}}" <?php if(old('subject') == $sub->id){ echo 'selected'; } ?>>{{$sub->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="selectDiv">
									<select name="status" id="status" class="form-control form-select-solid">
										<option value="">All</option>
										<option value="active">Active</option>
										<option value="inactive">Inactive</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="d-flex align-items-center position-relative">
									<span class="svg-icon svg-icon-1 position-absolute ms-4">
										<i class="las la-search"></i>
									</span>
									<input type="text" class="form-control form-control-solid ps-14" placeholder="Search" id="search_filter" name="search_filter">
								</div>
							</div>
							<div class="col-md-2">
								<button type="button" id="searchCourse" class="btn btn-dark btn-sm w-100">Search</button>
							</div>
						</div>
					</div>
				</div>

				<div class="card card-flush">
					<!--begin::Card body-->
					<div class="card-body">
						<!--begin::Table-->
						<div class="alert alert-success successMsg-show" style="display:none;"></div>
						<div class="alert alert-danger errorMsg-show" style="display:none;"></div>
						<div id="kt_ecommerce_products_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
							<div class="table-responsive showTable">
								Loading...
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
	<script type="text/javascript">
		$(document).ready(function(){
			getTable();
			$('#kt_help').show();
			$(document).on('click', '#searchCourse', function(){
				getTable();
			});
			$(document).on('click', '.pagination a', function(event){
		        event.preventDefault();
		        if($(this).hasClass('disabled')){
		            return false;
		        }
		        var page = $(this).attr('href').split('page=')[1];
		        $('#hidden_page').val(page);
		        $('li').removeClass('active');
		        $(this).parent().addClass('active');
		        getTable();
		    });
			function getTable(){
				$('.showTable').find('#coursesection').addClass('loading');
				var page = $('#hidden_page').val();

				var search = $('#search_filter').val();
				var category = $('#category').val();
				var subject = $('#subject').val();
				var status = $('#status').val();
				$('.errorMsg-show').html('').hide();
				$.ajax({
	                url:"{{ url('/courses/listing') }}",
	                data: { search:search,category:category,subject:subject,status:status,page:page },
	                type:"GET",
	                success: function(res){
	                    if(res.status == 'success'){
	                    	$('.showTable').html('').html(res.data);
	                    	$('.showTable').find('#coursesection').removeClass('loading');
	                    }else if(res.status == 'error'){
	                    	$('.errorMsg-show').html(res.msg).show();
	                    }
	                },error: function(e){
	                	 $('.showTable').find('#coursesection').removeClass('loading');
	                    $('.errorMsg-show').html(e.responseText).show();
	                }
	            });
	            return false;
			}

		});
	</script>
@endsection