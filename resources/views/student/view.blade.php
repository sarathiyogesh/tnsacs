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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Manage Student</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<!-- <div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="javascript:;" id="showImport" class="btn btn-sm btn-primary" >Import Students</a>
					<a href="{{ asset('sample-students.xlsx') }}">Sample Excel</a>
				</div> -->
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
						<div class="card-header-title">Search by Filter</div>
						<div class="row">
							<div class="col-md-3">
								<div class="d-flex align-items-center position-relative">
									<span class="svg-icon svg-icon-1 position-absolute ms-4">
										<i class="las la-search"></i>
									</span>
									<input type="text" class="form-control form-control-solid ps-14" placeholder="Search" id="search_filter" name="search_filter">
								</div>
							</div>
							<div class="col-md-3">
								<select name="institution" id="institution" class="form-select form-control form-control-solid">
									<option value="">Select Institution</option>
									@foreach($institutions as $in)
										<option value="{{ $in->id }}">{{ $in->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-2">
								<button type="button" id="searchbtn" class="btn btn-primary btn-sm">Search</button>
							</div>
						</div>
					</div>
				</div>
				{!! Helpers::displaymsg() !!}
				@if($errors->has("student_file"))
					<div class="alert alert-danger">{!! $errors->first("student_file") !!}</div>
				@endif
				<div class="card card-flush">
					<!--begin::Card body-->
					<div class="card-body">
						<!--begin::Table-->
						<div id="kt_ecommerce_products_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer scroll-x">
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


<!-- Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog d-flex justify-content-center">
        <div class="modal-content w-75">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Import Student</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form  action="/student/import" class="selectiveForm" method="POST"enctype="multipart/form-data">
                    <!-- Name input -->
                    @csrf
                    <div class="form-outline mb-4">
                        <input type="file" name="student_file" id="students" class="form-control" />
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
@endsection

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
			getTable();

			$(document).on('click', '#showImport', function(){
				$('#importModal').modal('show');
			});

			$(document).on('click', '#searchbtn', function(){
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
				var search = $('#search_filter').val();
				var institution = $('#institution').val();
				$.ajax({
	                url:"{{ url('student/view') }}",
	                data: { search:search,  page:page, institution:institution },
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

	</script>
@endsection