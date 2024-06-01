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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Manage Partner Offer</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					@can('partner-offer-add')
						<a href="{{url('partner/offercode/create')}}" id="kt_help_toggle" class="btn btn-sm btn-primary" >Add Offer Code</a>
					@endcan

					<a href="{{url('partner/offercode/import')}}" id="kt_help_toggle" class="btn btn-sm btn-primary" >Import Offer Code</a>
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
						<div class="card-header-title">Search by Filter</div>
						<div class="row">
							<!-- <div class="col-md-3">
								<div class="d-flex align-items-center position-relative">
									<span class="svg-icon svg-icon-1 position-absolute ms-4">
										<i class="las la-search"></i>
									</span>
									<input type="text" class="form-control form-control-solid ps-14" placeholder="Search name" id="searchkey" name="searchkey">
								</div>
							</div> -->

							<div class="col-md-3">
								<div class="d-flex align-items-center position-relative">
									<select id="partner" name="partner" class="form-control" data-control="select2" data-placeholder="All Partner" class="form-select form-select-solid form-select-lg fw-bold">
										<option value="">All</option>
										@foreach($partners as $par)
										<option value="{{$par->id}}">{{$par->partner_name}} ({{$par->offer_type=='bank'?'BIN':'Code'}})</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-md-3">
								<div class="d-flex align-items-center position-relative">
									<select id="status" name="status" class="form-control" data-control="select2" data-placeholder="All Status" class="form-select form-select-solid form-select-lg fw-bold">
										<option value="">All</option>
										<option value="1">Active</option>
										<option value="0">Inactive</option>
										<option value="2">Used</option>
									</select>
								</div>
							</div>

							<div class="col-md-2">
								<button type="submit" id="search_filter" class="btn btn-primary btn-sm">Search</button>
							</div>
						</div>
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
	<script type="text/javascript">
		$(document).ready(function(){
			getTable();

			$(document).on('click', '#search_filter', function(){
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
				var search = $('#searchkey').val();
				var partner = $('#partner').val();
				var status = $('#status').val();
				$.ajax({
	                url:"{{ url('partner/offercode/view') }}",
	                data: { search:search,  page:page,partner:partner,status:status },
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